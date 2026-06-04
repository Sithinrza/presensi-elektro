<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\Agama;
use App\Models\Presensi; 
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = SiswaMagang::where('id_user', $user->id_user)->first();

        // 1. Cek Kelengkapan SEMUA Data Biodata
        $isProfilLengkap = true;

        if (!$siswa) {
            $isProfilLengkap = false;
        } else {
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
        }

        $agama = Agama::all();

        // ==========================================
        // DATA STATISTIK KEHADIRAN BULAN INI (Berdasarkan CI)
        // ==========================================
        $bulanIni = Carbon::now('Asia/Makassar')->month;
        $tahunIni = Carbon::now('Asia/Makassar')->year;

        // Tarik semua data presensi bulan ini
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

        // Anggap total hari kerja magang 20 hari (Senin-Jumat)
        $total_hari_kerja = 20;

        return view('siswa.dashboard.index', compact(
            'siswa', 'isProfilLengkap', 'agama',
            'hadir', 'tepatWaktu', 'telat', 'alpa', 'total_hari_kerja'
        ));
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
