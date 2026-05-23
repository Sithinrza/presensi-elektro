<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Mengambil nama role dalam huruf kecil sesuai database
        $role = strtolower($user->roles->first()->name);

        // Filter Bulan & Tahun (Default ke bulan/tahun berjalan)
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Ambil Data Riwayat milik User yang sedang login
        $riwayat = Presensi::with('statusPresensi')
                    ->where('id_user', $user->id_user)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // ==========================================
        // Hitung Statistik Menggunakan ID Database Real
        // 1 = Hadir, 2 = Terlambat, 3 = Alfa
        // ==========================================
        $hadir = $riwayat->where('id_status_presensi', 1)->count();
        $telat = $riwayat->where('id_status_presensi', 2)->count();
        $alfa  = $riwayat->where('id_status_presensi', 3)->count();

        // Tentukan Layout & Dashboard URL secara otomatis
        if ($role == 'tendik') {
            $layout = 'layouts.tendik';
            $url_dashboard = route('tendik.dashboard');
        } else {
            $layout = 'layouts.siswa';
            $url_dashboard = route('siswa.dashboard');
        }

        return view('presensi.riwayat-presensi', compact(
            'riwayat', 'layout', 'role', 'url_dashboard',
            'hadir', 'telat', 'alfa', 'bulan', 'tahun'
        ));
    }
}
