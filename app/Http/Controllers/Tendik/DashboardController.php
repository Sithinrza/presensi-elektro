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
        $isProfilLengkap = $tendik &&
                            !empty($tendik->nip) &&
                            !empty($tendik->jk) &&
                            !empty($tendik->no_hp) &&
                            !empty($tendik->alamat) &&
                            !empty($tendik->tempat_lahir) &&
                            !empty($tendik->tanggal_lahir) &&
                            !empty($tendik->id_pend_terakhir);

        // Data pendukung untuk form
        $agama = Agama::all();
        $pendidikan = PendidikanTerakhir::all();

        $bulanIni = Carbon::now('Asia/Makassar')->month;
        $tahunIni = Carbon::now('Asia/Makassar')->year;

        $presensiBulanIni = Presensi::where('id_user', $user->id_user)
                                    ->whereMonth('tanggal', $bulanIni)
                                    ->whereYear('tanggal', $tahunIni)
                                    ->get();

        // 1. Tepat Waktu (Status CI = 1)
        $tepatWaktu = $presensiBulanIni->where('id_status_ci', 1)->count();

        // 2. Terlambat (Status CI = 2)
        $telat = $presensiBulanIni->where('id_status_ci', 2)->count();

        // 3. Total Hadir (Tepat Waktu + Terlambat)
        $hadir = $tepatWaktu + $telat;

        // 4. Alpa (Status CI = 3)
        $alpa = $presensiBulanIni->where('id_status_ci', 3)->count();

        return view('tendik.dashboard.index', compact(
            'tendik', 'isProfilLengkap', 'agama', 'pendidikan', 'hadir', 'tepatWaktu', 'telat', 'alpa'
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
