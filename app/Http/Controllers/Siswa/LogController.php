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
       
        $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'uraian'  => 'required|string|min:10',
        ]);

        $user = Auth::user();
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');

        // Keamanan ganda: Tolak simpan log via backend jika HARI INI belum presensi masuk
        $cekPresensi = Presensi::where('id_user', $user->id_user)
                               ->where('tanggal', $tanggalHariIni)
                               ->first();

        if (!$cekPresensi) {
            return redirect()->back()->with('error', 'Anda harus melakukan presensi masuk hari ini terlebih dahulu sebelum mengisi logbook!');
        }


        $tanggalPilih = Carbon::parse($request->tanggal);

        // Simpan data log baru
        Log::create([
            'id_user'            => $user->id_user,
            'title'              => 'Log Kegiatan - ' . $tanggalPilih->translatedFormat('d F Y'),
            'description'        => $request->uraian,
            'report_date'        => $request->tanggal,
            'status'             => 'pending',
            'catatan_pembimbing' => null
        ]);

        return redirect()->back()->with('success', 'Logbook kegiatan berhasil disimpan dan menunggu pemeriksaan pembimbing.');
    }
}
