<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use App\Models\Pembimbing;
use App\Models\StatusPresensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now('Asia/Makassar')->format('Y-m-d');

        // 1. Ambil ID Status secara dinamis dari tabel status_presensi
        $idTepatWaktu = StatusPresensi::where('name', 'Tepat Waktu')->value('id_status_presensi');
        $idTerlambat  = StatusPresensi::where('name', 'Terlambat')->value('id_status_presensi');
        $idAlpa       = StatusPresensi::where('name', 'Alpa')->value('id_status_presensi');

        // 2. Hitung Status Presensi Hari Ini (Menggunakan ID Dinamis)
        $hadirHariIni     = Presensi::where('tanggal', $hariIni)->where('id_status_ci', $idTepatWaktu)->count();
        $terlambatHariIni = Presensi::where('tanggal', $hariIni)->where('id_status_ci', $idTerlambat)->count();
        $alpaHariIni      = Presensi::where('tanggal', $hariIni)->where('id_status_ci', $idAlpa)->count();

        // 3. Hitung Total Data Master
        $totalSiswa      = SiswaMagang::count();
        $totalTendik     = Tendik::count();
        $totalPembimbing = Pembimbing::count();

        // 4. Ambil 10 Aktivitas Terbaru Hari Ini
        $aktivitasHariIni = Presensi::with(['user.roles', 'statusCi', 'statusCo'])
            ->where('tanggal', $hariIni)
            ->orderBy('updated_at', 'desc') // Biar yang baru absen pulang juga naik ke atas
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
