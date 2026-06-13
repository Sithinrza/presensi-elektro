<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\StatusPresensi; // <-- WAJIB IMPORT INI
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data pembimbing berdasarkan user yang sedang login
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->first();

        // Proteksi jika data pembimbing tidak ditemukan
        if (!$pembimbing) {
            return redirect()->route('login')->with('error', 'Profil pembimbing tidak ditemukan.');
        }

        $id_pembimbing = $pembimbing->id_pembimbing;
        $hariIni = Carbon::today();

        // 2. Kumpulkan ID User dari semua siswa bimbingannya
        $siswaIds = SiswaMagang::where('id_pembimbing', $id_pembimbing)->pluck('id_user');

        // Ambil ID Status Tepat Waktu dan Terlambat secara dinamis
        $idTepatWaktu = StatusPresensi::where('name', 'Tepat Waktu')->value('id_status_presensi');
        $idTerlambat  = StatusPresensi::where('name', 'Terlambat')->value('id_status_presensi');

        // 3. HITUNG STATISTIK ATAS (KOTAK 4 BUAH)
        $totalBimbingan = $siswaIds->count();

        // Hitung Logbook yang statusnya 'Pending'
        $totalLogPending = \App\Models\Log::whereIn('id_user', $siswaIds)
                                          ->where('status', 'Pending')
                                          ->count();

        // PERBAIKAN: Hitung Presensi Hadir menggunakan variabel ID yang sudah dicari
        $hadirHariIni = \App\Models\Presensi::whereIn('id_user', $siswaIds)
                                            ->whereDate('tanggal', $hariIni)
                                            ->whereIn('id_status_ci', [$idTepatWaktu, $idTerlambat])
                                            ->count();

        // Hitung Siswa yang masa magangnya sudah habis (Siap dinilai)
        $siapPenilaian = SiswaMagang::where('id_pembimbing', $id_pembimbing)
                                    ->whereDate('tanggal_selesai', '<=', $hariIni)
                                    ->count();

        // 4. AMBIL DAFTAR SISWA BESERTA STATISTIK PRIBADINYA
        $daftarSiswa = SiswaMagang::where('id_pembimbing', $id_pembimbing)
            ->withCount([
                // PERBAIKAN: Hitung jumlah hadir bulan ini menggunakan ID dinamis
                'presensi as hadir_bulan_ini' => function ($query) use ($hariIni, $idTepatWaktu, $idTerlambat) {
                    $query->whereMonth('tanggal', $hariIni->month)
                          ->whereYear('tanggal', $hariIni->year)
                          ->whereIn('id_status_ci', [$idTepatWaktu, $idTerlambat]);
                },
                // Hitung jumlah logbook pending per siswa
                'logbook as log_pending' => function ($query) {
                    $query->where('status', 'Pending');
                }
            ])
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('pembimbing.dashboard.index', compact(
            'pembimbing', 'totalBimbingan', 'totalLogPending',
            'hadirHariIni', 'siapPenilaian', 'daftarSiswa'
        ));
    }

    public function show($id)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        // Cari data siswa (Pastikan siswa ini memang bimbingan dari dosen yang sedang login)
        $siswa = SiswaMagang::with('user')
            ->where('id_pembimbing', $pembimbing->id_pembimbing)
            ->findOrFail($id);

        // Ambil riwayat presensi, urutkan dari yang terbaru
        $presensi = Presensi::where('id_user', $siswa->id_user)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Ambil riwayat logbook, urutkan dari yang terbaru
        $logbook = Log::where('id_user', $siswa->id_user)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pembimbing.presensi-siswa.show', compact('siswa', 'presensi', 'logbook'));
    }
}
