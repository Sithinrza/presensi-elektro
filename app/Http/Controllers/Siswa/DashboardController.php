<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\Agama;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = SiswaMagang::where('id_user', $user->id_user)->first();

        // 1. Cek Kelengkapan SEMUA Data Biodata
        $isProfilLengkap = true;
        if (
            is_null($siswa->nis) ||
            is_null($siswa->id_agama) ||
            is_null($siswa->sekolah_asal) ||
            is_null($siswa->jurusan) ||
            is_null($siswa->jk) ||
            is_null($siswa->tempat_lahir) ||
            is_null($siswa->tanggal_lahir) ||
            is_null($siswa->no_hp) ||
            is_null($siswa->alamat)
        ) {
            $isProfilLengkap = false;
        }

        $agama = Agama::all();

        return view('siswa.dashboard.index', compact('siswa', 'isProfilLengkap', 'agama'));
    }

    public function simpanProfilLengkap(Request $request)
    {
        // 2. Validasi Seluruh Kolom Database
        $request->validate([
            'nis'           => 'required|string|max:50',
            'id_agama'      => 'required|integer',
            'sekolah_asal'  => 'required|string|max:100',
            'jurusan'       => 'required|string|max:100',
            'jk'            => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string',
        ]);

        $user = Auth::user();

        // 3. Update Seluruh Data
        SiswaMagang::where('id_user', $user->id_user)->update([
            'nis'           => $request->nis,
            'id_agama'      => $request->id_agama,
            'sekolah_asal'  => $request->sekolah_asal,
            'jurusan'       => $request->jurusan,
            'jk'            => $request->jk,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Profil Anda sudah lengkap.');
    }
}
