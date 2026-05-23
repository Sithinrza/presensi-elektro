<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');

        // 1. Cek apakah hari ini sudah melakukan presensi masuk
        $cekPresensi = Presensi::where('id_user', $user->id_user)
                               ->where('tanggal', $tanggalHariIni)
                               ->first();

        $sudahAbsen = $cekPresensi ? true : false;

        // 2. Ambil riwayat log milik siswa yang sedang login
        $riwayatLog = Log::where('id_user', $user->id_user)
                         ->orderBy('report_date', 'desc')
                         ->get();

        // 3. Cek apakah hari ini sudah pernah menginput log (agar tidak double input)
        $sudahIsiLogHariIni = Log::where('id_user', $user->id_user)
                                 ->whereDate('report_date', $tanggalHariIni)
                                 ->exists();

        return view('siswa.log.index', compact('sudahAbsen', 'riwayatLog', 'sudahIsiLogHariIni', 'tanggalHariIni'));
    }

    public function store(Request $request)
    {
        // Validasi deskripsi uraian pekerjaan dari textarea FE
        $request->validate([
            'kegiatan' => 'required|string|min:10',
        ]);

        $user = Auth::user();
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');

        // Keamanan ganda: Tolak simpan log via backend jika hari ini belum presensi masuk
        $cekPresensi = Presensi::where('id_user', $user->id_user)->where('tanggal', $tanggalHariIni)->first();
        if (!$cekPresensi) {
            return redirect()->back()->with('error', 'Anda harus melakukan presensi masuk terlebih dahulu sebelum mengisi logbook!');
        }

        // Simpan data log baru
        Log::create([
            'id_user'            => $user->id_user,
            // Judul otomatis diset sistem berdasarkan tanggal hari ini biar ga ngerubah form FE
            'title'              => 'Log Kegiatan - ' . $waktuSekarang->translatedFormat('d F Y'),
            'description'        => $request->kegiatan,
            'report_date'        => $waktuSekarang,
            'status'             => 'pending',
            'catatan_pembimbing' => null
        ]);

        return redirect()->back()->with('success', 'Logbook kegiatan hari ini berhasil disimpan dan menunggu pemeriksaan pembimbing.');
    }
}
