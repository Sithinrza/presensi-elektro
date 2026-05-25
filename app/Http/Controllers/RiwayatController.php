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
        $role = strtolower($user->roles->first()->name);

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Panggil relasi yang baru: statusCi, statusCo, dan klaim
        $riwayat = Presensi::with(['statusCi', 'statusCo', 'klaim'])
                           ->where('id_user', $user->id_user)
                           ->whereMonth('tanggal', $bulan)
                           ->whereYear('tanggal', $tahun)
                           ->orderBy('tanggal', 'desc')
                           ->get();

        // Hitung statistik berdasarkan status pagi (Check-In)
        $hadir = $riwayat->where('id_status_ci', 1)->count();
        $telat = $riwayat->where('id_status_ci', 2)->count();
        $alfa  = $riwayat->where('id_status_ci', 3)->count();

        if ($role == 'tendik') {
            $layout = 'layouts.tendik';
        } elseif ($role == 'siswa' || $role == 'siswa magang') {
            $layout = 'layouts.siswa';
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('presensi.riwayat-presensi', compact('layout', 'riwayat', 'bulan', 'tahun', 'hadir', 'telat', 'alfa'));
    }
}
