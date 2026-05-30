<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\SiswaMagang;
use App\Models\Pembimbing;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class PresensiSiswaController extends Controller
{
    public function index()
    {
        $pembimbing = Pembimbing::where('id_user', Auth::id())->first();

        $anakBimbingan = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing)
                                    ->with(['presensi.statusCi', 'presensi.statusCo'])
                                    ->get();

        return view('pembimbing.presensi-siswa.index', compact('anakBimbingan'));
    }

    public function show($id_user)
    {
        $siswa = SiswaMagang::where('id_user', $id_user)->firstOrFail();

        $riwayatPresensi = Presensi::with(['statusCi', 'statusCo'])
                                   ->where('id_user', $id_user)
                                   ->orderBy('tanggal', 'desc')
                                   ->get();

        // Statistik sekarang mencakup CI dan CO
        $statistik = [
            'Tepat CI' => $riwayatPresensi->where('statusCi.name', 'Tepat Waktu')->count(),
            'Telat CI' => $riwayatPresensi->where('statusCi.name', 'Terlambat')->count(),
            'Alfa'     => $riwayatPresensi->where('statusCi.name', 'Alfa')->count(),
            'Tepat CO' => $riwayatPresensi->where('statusCo.name', 'Tepat Waktu')->count(),
            'Lupa CO'  => $riwayatPresensi->where('statusCo.name', 'Lupa Check-Out')->count(),
        ];

        return view('pembimbing.presensi-siswa.show', compact('siswa', 'riwayatPresensi', 'statistik'));
    }
}
