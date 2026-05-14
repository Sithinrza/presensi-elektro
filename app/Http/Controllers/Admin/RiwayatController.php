<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        // Data default: Ambil semua Siswa Magang beserta efektivitas kehadirannya
        $siswa = SiswaMagang::with('user')->get();
        $tendik = Tendik::with('user')->get();

        return view('admin.riwayat-presensi.index', compact('siswa', 'tendik'));
    }

    public function showDetail($id_user)
    {
        // Mengambil riwayat detail per individu untuk ditampilkan di Detail View
        $riwayat = Presensi::where('id_user', $id_user)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return response()->json($riwayat);
    }
}
