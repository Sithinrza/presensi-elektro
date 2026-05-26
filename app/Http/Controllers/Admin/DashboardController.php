<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use App\Models\Pembimbing;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Dapatkan tanggal hari ini
        $hariIni = Carbon::today()->toDateString();

        // 2. Hitung Status Presensi Hari Ini Berdasarkan Status Masuk (id_status_ci)
        // 1 = Hadir, 2 = Terlambat, 3 = Alfa
        $hadirHariIni = Presensi::where('tanggal', $hariIni)->where('id_status_ci', 1)->count();
        $terlambatHariIni = Presensi::where('tanggal', $hariIni)->where('id_status_ci', 2)->count();
        $alpaHariIni = Presensi::where('tanggal', $hariIni)->where('id_status_ci', 3)->count();

        // 3. Hitung Total Data Master
        $totalSiswa = SiswaMagang::count();
        $totalTendik = Tendik::count();
        $totalPembimbing = Pembimbing::count();

        // 4. Ambil 10 Aktivitas Terbaru Hari Ini dengan Eager Loading Relasi Status
        $aktivitasHariIni = Presensi::with(['user', 'statusCi', 'statusCo'])
            ->where('tanggal', $hariIni)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'hadirHariIni',
            'terlambatHariIni',
            'alpaHariIni',
            'totalSiswa',
            'totalTendik',
            'totalPembimbing',
            'aktivitasHariIni'
        ));
    }
}
