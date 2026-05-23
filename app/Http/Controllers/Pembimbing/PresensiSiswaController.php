<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\SiswaMagang;
use App\Models\Pembimbing;
use App\Models\Presensi; // Import model Presensi
use Illuminate\Support\Facades\Auth;

class PresensiSiswaController extends Controller
{
    public function index()
    {
        $pembimbing = Pembimbing::where('id_user', Auth::id())->first();
        // Ambil siswa bimbingan beserta relasi presensinya
        $anakBimbingan = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing)
                                    ->with(['presensi'])
                                    ->get();

        return view('pembimbing.presensi-siswa.index', compact('anakBimbingan'));
    }

    public function show($id)
    {
        $siswa = SiswaMagang::where('id_siswa', $id)->firstOrFail();

        $riwayatPresensi = Presensi::where('id_user', $siswa->id_user)
                                   ->orderBy('tanggal', 'desc')
                                   ->get();

        // Hitung statistik untuk header
        $statistik = [
            'Hadir'  => $riwayatPresensi->where('status', 'Hadir')->count(),
            'Telat'  => $riwayatPresensi->where('status', 'Terlambat')->count(),
            'Alfa'   => $riwayatPresensi->where('status', 'Alfa')->count(),
        ];

        return view('pembimbing.presensi-siswa.show', compact('siswa', 'riwayatPresensi', 'statistik'));
    }
}
