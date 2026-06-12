<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\Agama;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = SiswaMagang::where('id_user', $user->id_user)->first();

        $isProfilLengkap = $siswa &&
                           !empty($siswa->nis) &&
                           !empty($siswa->id_agama) &&
                           !empty($siswa->sekolah_asal) &&
                           !empty($siswa->jurusan) &&
                           !empty($siswa->jk) &&
                           !empty($siswa->tempat_lahir) &&
                           !empty($siswa->tanggal_lahir) &&
                           !empty($siswa->no_hp) &&
                           !empty($siswa->alamat);

        $agama = Agama::all();

        // ==========================================
        // DATA STATISTIK KEHADIRAN BULAN INI
        // ==========================================
        $bulanIni = Carbon::now('Asia/Makassar')->month;
        $tahunIni = Carbon::now('Asia/Makassar')->year;

        // Ambil ID secara dinamis dari database agar tidak pernah salah
        $idTepatWaktu = StatusPresensi::where('name', 'Tepat Waktu')->value('id_status_presensi');
        $idTerlambat  = StatusPresensi::where('name', 'Terlambat')->value('id_status_presensi');
        $idAlpa       = StatusPresensi::where('name', 'Alpa')->value('id_status_presensi');

        // Tarik semua data presensi bulan ini
        $presensiBulanIni = Presensi::where('id_user', $user->id_user)
                                    ->whereMonth('tanggal', $bulanIni)
                                    ->whereYear('tanggal', $tahunIni)
                                    ->get();

        // 1. Tepat Waktu
        $tepatWaktu = $presensiBulanIni->where('id_status_ci', $idTepatWaktu)->count();

        // 2. Terlambat
        $telat = $presensiBulanIni->where('id_status_ci', $idTerlambat)->count();

        // 3. Total Hadir (Tepat Waktu + Terlambat)
        $hadir = $tepatWaktu + $telat;

        // 4. Alfa
        $alpa = $presensiBulanIni->where('id_status_ci', $idAlpa)->count();

        // Anggap total hari kerja magang 20 hari (Senin-Jumat)
        $total_hari_kerja = 20;

        // ==========================================
        // FITUR BARU: CEK STATUS PRESENSI HARI INI
        // ==========================================
        $hariIni = Carbon::now('Asia/Makassar')->format('Y-m-d');
        $presensiHariIni = Presensi::where('id_user', $user->id_user)
                                   ->where('tanggal', $hariIni)
                                   ->first();

        return view('siswa.dashboard.index', compact(
            'siswa', 'isProfilLengkap', 'agama',
            'hadir', 'tepatWaktu', 'telat', 'alpa', 'total_hari_kerja',
            'presensiHariIni'
        ));
    }

    public function simpanProfilLengkap(Request $request)
    {
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
