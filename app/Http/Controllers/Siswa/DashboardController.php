<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\Agama;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use App\Models\HariLibur;
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

        $idTepatWaktu = StatusPresensi::where('name', 'Tepat Waktu')->value('id_status_presensi');
        $idTerlambat  = StatusPresensi::where('name', 'Terlambat')->value('id_status_presensi');
        $idAlpa       = StatusPresensi::where('name', 'Alpa')->value('id_status_presensi');

        $presensiBulanIni = Presensi::where('id_user', $user->id_user)
                                    ->whereMonth('tanggal', $bulanIni)
                                    ->whereYear('tanggal', $tahunIni)
                                    ->get();

        $tepatWaktu = $presensiBulanIni->where('id_status_ci', $idTepatWaktu)->count();
        $telat = $presensiBulanIni->where('id_status_ci', $idTerlambat)->count();
        $hadir = $tepatWaktu + $telat;
        $alpa = $presensiBulanIni->where('id_status_ci', $idAlpa)->count();

        $total_hari_kerja = 20;

        // ==========================================
        // LOGIKA STATUS TOMBOL PRESENSI
        // ==========================================
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');
        $jamSekarang = $waktuSekarang->format('H:i:s');
        $hariIniIso = $waktuSekarang->dayOfWeekIso;

        $presensiHariIni = Presensi::where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        // Cek Dosa Lupa CO
        $statusLupaCO = StatusPresensi::where('name', 'Lupa Check-Out')->first();
        $presensiGantung = null;
        if ($statusLupaCO) {
            $presensiGantung = Presensi::where('id_user', $user->id_user)
                                       ->where('id_status_co', $statusLupaCO->id_status_presensi)
                                       ->whereNull('alasan')
                                       ->orderBy('tanggal', 'asc')
                                       ->first();
        }

        $isWeekend = in_array($hariIniIso, [6, 7]);
        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();
        $belumBuka = $jamSekarang < '06:00:00';

        // 🚨 PERBAIKAN LOGIKA TOMBOL BLOKIR
        $batasBatasCo = ($hariIniIso == 5) ? '17:30:00' : '17:00:00';
        $lewatJamCo = ($jamSekarang > $batasBatasCo) && (!$presensiHariIni || (is_null($presensiHariIni->jam_masuk) && empty($presensiHariIni->alasan)));

        $batasBlokirMasuk = ($hariIniIso == 5) ? '16:30:00' : '16:00:00';
        $lewatBatasMasuk = ($jamSekarang >= $batasBlokirMasuk && (!$presensiHariIni || (is_null($presensiHariIni->jam_masuk) && empty($presensiHariIni->alasan))));

        return view('siswa.dashboard.index', compact(
            'siswa', 'isProfilLengkap', 'agama',
            'hadir', 'tepatWaktu', 'telat', 'alpa', 'total_hari_kerja',
            'presensiHariIni', 'isWeekend', 'hariLiburIni', 'belumBuka', 'lewatJamCo', 'lewatBatasMasuk', 'presensiGantung'
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
