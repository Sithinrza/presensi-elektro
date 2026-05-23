<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendik;
use App\Models\Agama;
use App\Models\PendidikanTerakhir;
use App\Models\Presensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil profil Tendik
        $tendik = Tendik::where('id_user', $user->id_user)->first();

        // Cek apakah data penting sudah diisi semua
        // (Sesuaikan field apa saja yang menurutmu wajib diisi sebelum bisa absen)
        $isProfilLengkap = $tendik &&
                           $tendik->nip &&
                           $tendik->jk &&
                           $tendik->no_hp &&
                           $tendik->alamat &&
                           $tendik->id_pend_terakhir;

        // Data pendukung untuk form
        $agama = Agama::all();
        $pendidikan = PendidikanTerakhir::all();

        // Data Statistik Kehadiran Bulan Ini
        $bulanIni = Carbon::now('Asia/Makassar')->month;
        $tahunIni = Carbon::now('Asia/Makassar')->year;

        $hadir = Presensi::where('id_user', $user->id_user)
                         ->whereMonth('tanggal', $bulanIni)
                         ->whereYear('tanggal', $tahunIni)
                         ->count();

        // Anggap total hari kerja 22 hari, sesuaikan dengan aturan instansi
        $total_hari_kerja = 22;
        $telat = 0; // Bisa dikembangkan dengan logika jam masuk > 08:00
        $alpa = $total_hari_kerja - $hadir;

        return view('tendik.dashboard.index', compact(
            'tendik', 'isProfilLengkap', 'agama', 'pendidikan', 'hadir', 'total_hari_kerja', 'telat', 'alpa'
        ));
    }

    public function lengkapiProfil(Request $request)
    {
        $request->validate([
            'nip'           => 'required|string|max:50',
            'id_agama'      => 'required|integer',
            'id_pend_terakhir' => 'required|integer',
            'jk'            => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:40',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string',
        ]);

        $user = Auth::user();
        $tendik = Tendik::where('id_user', $user->id_user)->first();

        if ($tendik) {
            $tendik->update([
                'nip'           => $request->nip,
                'id_agama'      => $request->id_agama,
                'id_pend_terakhir' => $request->id_pend_terakhir,
                'jk'            => $request->jk,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp'         => $request->no_hp,
                'alamat'        => $request->alamat,
            ]);

            return redirect()->back()->with('success', 'Profil berhasil dilengkapi! Anda sekarang dapat melakukan presensi.');
        }

        return redirect()->back()->with('error', 'Data profil tidak ditemukan!');
    }
}
