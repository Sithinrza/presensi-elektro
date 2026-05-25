<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        $totalHariKerja = 22;

        $siswa = SiswaMagang::with('user')->get()->map(function ($s) use ($totalHariKerja) {
            // Dihitung berdasarkan status CI = Tepat Waktu (ID 1)
            $totalHadir = Presensi::where('id_user', $s->id_user)
                                  ->where('id_status_ci', 1)
                                  ->whereMonth('tanggal', date('m'))
                                  ->count();

            $efektivitas = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100) : 0;
            $s->efektivitas = $efektivitas > 100 ? 100 : $efektivitas;
            return $s;
        });

        $tendik = Tendik::with(['user', 'unitKerja'])->get()->map(function ($t) use ($totalHariKerja) {
            $totalHadir = Presensi::where('id_user', $t->id_user)
                                  ->where('id_status_ci', 1)
                                  ->whereMonth('tanggal', date('m'))
                                  ->count();

            $efektivitas = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100) : 0;
            $t->efektivitas = $efektivitas > 100 ? 100 : $efektivitas;
            return $t;
        });

        return view('admin.riwayat-presensi.index', compact('siswa', 'tendik'));
    }

    public function showDetail($id_user)
    {
        // Panggil relasi statusCi dan statusCo
        $riwayat = Presensi::with(['statusCi', 'statusCo'])
                    ->where('id_user', $id_user)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // Hitung statistik dari id_status_ci
        $statistik = [
            'hadir' => $riwayat->where('id_status_ci', 1)->count(), // Tepat Waktu
            'telat' => $riwayat->where('id_status_ci', 2)->count(), // Terlambat
            'alfa'  => $riwayat->where('id_status_ci', 3)->count(), // Alfa
        ];

        return response()->json([
            'riwayat' => $riwayat,
            'statistik' => $statistik
        ]);
    }
}
