<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\StatusPresensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->first();

        if (!$pembimbing) {
            return redirect()->route('login')->with('error', 'Profil pembimbing tidak ditemukan.');
        }

        $id_pembimbing = $pembimbing->id_pembimbing;
        $hariIni = Carbon::now('Asia/Makassar');
        $hariIniTanggal = $hariIni->format('Y-m-d');

        $siswaIds = SiswaMagang::where('id_pembimbing', $id_pembimbing)->pluck('id_user');

        $idTepatWaktu = StatusPresensi::where('name', 'Tepat Waktu')->value('id_status_presensi');
        $idTerlambat  = StatusPresensi::where('name', 'Terlambat')->value('id_status_presensi');

        // Hitung statistik global untuk kotak atas
        $totalBimbingan = $siswaIds->count();
        $totalLogPending = Log::whereIn('id_user', $siswaIds)->where('status', 'Pending')->count();
        $hadirHariIni = Presensi::whereIn('id_user', $siswaIds)
                                    ->whereDate('tanggal', $hariIniTanggal)
                                    ->whereIn('id_status_ci', [$idTepatWaktu, $idTerlambat])
                                    ->count();

        $siapPenilaian = SiswaMagang::where('id_pembimbing', $id_pembimbing)
                                    ->where(function($q) use ($hariIniTanggal) {
                                        $q->where('status', 'Nonaktif')
                                          ->orWhereDate('tanggal_selesai', '<=', $hariIniTanggal);
                                    })
                                    ->count();

        // 👈 PERBAIKAN: DAFTAR SISWA DI DASHBOARD HANYA YANG AKTIF & BELUM KEDALUWARSA
        $daftarSiswa = SiswaMagang::where('id_pembimbing', $id_pembimbing)
            ->where('status', 'Aktif')
            ->whereDate('tanggal_selesai', '>', $hariIniTanggal)
            ->with(['presensi' => function($query) use ($hariIniTanggal) {
                $query->whereDate('tanggal', $hariIniTanggal)->with('statusCi');
            }])
            ->withCount([
                'presensi as hadir_bulan_ini' => function ($query) use ($hariIni, $idTepatWaktu, $idTerlambat) {
                    $query->whereMonth('tanggal', $hariIni->month)
                          ->whereYear('tanggal', $hariIni->year)
                          ->whereIn('id_status_ci', [$idTepatWaktu, $idTerlambat]);
                },
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

        $siswa = SiswaMagang::with('user')
            ->where('id_pembimbing', $pembimbing->id_pembimbing)
            ->findOrFail($id);

        $presensi = Presensi::where('id_user', $siswa->id_user)
            ->orderBy('tanggal', 'desc')
            ->get();

        $logbook = Log::where('id_user', $siswa->id_user)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pembimbing.presensi-siswa.show', compact('siswa', 'presensi', 'logbook'));
    }
}
