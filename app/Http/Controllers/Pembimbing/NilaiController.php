<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\SiswaMagang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        // Ambil daftar siswa bimbingannya
        $daftarSiswa = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing)
            ->orderBy('tanggal_selesai', 'asc') // Urutkan dari yang paling cepat selesai magang
            ->get();

        $hariIni = Carbon::today();

        return view('pembimbing.nilai.index', compact('daftarSiswa', 'hariIni'));
    }
}
