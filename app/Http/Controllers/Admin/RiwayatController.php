<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        // Total hari kerja dalam bulan ini (asumsi kasar 22 hari, bisa disesuaikan)
        $totalHariKerja = 22;

        // 1. Ambil Data Siswa + Hitung Efektivitas
        $siswa = SiswaMagang::with('user')->get()->map(function ($s) use ($totalHariKerja) {
            $totalHadir = Presensi::where('id_user', $s->id_user)
                                  ->where('id_status_presensi', 1) // 1 = Hadir
                                  ->whereMonth('tanggal', date('m'))
                                  ->count();

            // Hitung persentase (Maksimal 100%)
            $efektivitas = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100) : 0;
            $s->efektivitas = $efektivitas > 100 ? 100 : $efektivitas;
            return $s;
        });

        // 2. Ambil Data Tendik + Hitung Efektivitas
        $tendik = Tendik::with(['user', 'unitKerja'])->get()->map(function ($t) use ($totalHariKerja) {
            $totalHadir = Presensi::where('id_user', $t->id_user)
                                  ->where('id_status_presensi', 1) // 1 = Hadir
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
        // Mengambil riwayat detail per individu
        $riwayat = Presensi::with('statusPresensi')
                    ->where('id_user', $id_user)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // Hitung statistik bulanan untuk user ini
        $statistik = [
            'hadir' => $riwayat->where('id_status_presensi', 1)->count(),
            'telat' => $riwayat->where('id_status_presensi', 2)->count(),
            'alfa'  => $riwayat->where('id_status_presensi', 3)->count(),
        ];

        return response()->json([
            'riwayat' => $riwayat,
            'statistik' => $statistik
        ]);
    }
}
