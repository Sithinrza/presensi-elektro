<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');

        // Mengambil relasi status_ci dan status_co
        $presensiHariIni = Presensi::with(['statusCi', 'statusCo'])
                                   ->where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        $presensiSelesai = $presensiHariIni && $presensiHariIni->jam_pulang != null;
        $belumWaktunyaPulang = false;
        $jadwalPulang = '16:00';

        if ($presensiHariIni && !$presensiSelesai) {
            $hariIni = $waktuSekarang->dayOfWeekIso;

            if ($hariIni == 5) { // Jika hari Jumat
                $batasPulang = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar');
                $jadwalPulang = '16:30';
            } else {
                $batasPulang = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
            }

            if ($waktuSekarang->lessThan($batasPulang)) {
                $belumWaktunyaPulang = true;
            }
        }

        if ($role == 'tendik') {
            $layout = 'layouts.tendik';
            $backUrl = route('tendik.dashboard');
            $url_dashboard = route('tendik.dashboard');
        } elseif ($role == 'siswa' || $role == 'siswa magang') {
            $layout = 'layouts.siswa';
            $backUrl = route('siswa.dashboard');
            $url_dashboard = route('siswa.dashboard');
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('presensi.index', compact('layout', 'backUrl', 'role', 'url_dashboard', 'presensiHariIni', 'presensiSelesai', 'belumWaktunyaPulang', 'jadwalPulang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_base64' => 'required',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
        ]);

        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');
        $jamSekarang = $waktuSekarang->format('H:i:s');

        $img = $request->image_base64;
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);

        $fileName = $user->id_user . '_' . $tanggalHariIni . '_' . time() . '.jpeg';
        $folderPath = "public/uploads/presensi/";
        Storage::put($folderPath . $fileName, $image_base64);

        $presensiHariIni = Presensi::where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        // 1. LOGIKA CHECK-IN
        if (!$presensiHariIni) {
            $batasHadir = Carbon::createFromTime(9, 0, 0, 'Asia/Makassar');
            $batasTelat = Carbon::createFromTime(9, 30, 0, 'Asia/Makassar');

            $statusNameCi = 'Tepat Waktu';

            if ($waktuSekarang->greaterThan($batasTelat)) {
                $statusNameCi = 'Alfa';
            } elseif ($waktuSekarang->greaterThan($batasHadir)) {
                $statusNameCi = 'Terlambat';
            }

            $statusDbCi = StatusPresensi::where('name', $statusNameCi)->first();

            if (!$statusDbCi) {
                return response()->json(['status' => 'error', 'message' => 'Status presensi CI tidak ditemukan!']);
            }

            Presensi::create([
                'id_user'            => $user->id_user,
                'id_status_ci'       => $statusDbCi->id_status_presensi,
                'tanggal'            => $tanggalHariIni,
                'jam_masuk'          => $jamSekarang,
                'foto_masuk'         => $fileName,
                'latitude_masuk'     => $request->latitude,
                'longitude_masuk'    => $request->longitude,
            ]);

            $pesan = ($statusNameCi == 'Alfa') ? 'Anda absen terlalu siang, status tercatat sebagai Alfa.' : 'Presensi Masuk Berhasil dicatat!';

        // 2. LOGIKA CHECK-OUT
        } else {
            if ($presensiHariIni->jam_pulang != null) {
                return response()->json(['status' => 'error', 'message' => 'Anda sudah melakukan presensi pulang hari ini!']);
            }

            $hariIni = $waktuSekarang->dayOfWeekIso;
            $batasPulang = ($hariIni == 5) ? Carbon::createFromTime(16, 30, 0, 'Asia/Makassar') : Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
            $batasLupaCO = Carbon::createFromTime(18, 0, 0, 'Asia/Makassar');

            // Cek apakah belum waktunya pulang
            if ($waktuSekarang->lessThan($batasPulang)) {
                return response()->json(['status' => 'error', 'message' => 'Belum waktunya pulang!']);
            }

            // Tentukan status CO
            $statusNameCo = 'Tepat Waktu';
            if ($waktuSekarang->greaterThanOrEqualTo($batasLupaCO)) {
                $statusNameCo = 'Lupa Check-Out';
            }

            $statusDbCo = StatusPresensi::where('name', $statusNameCo)->first();

            $presensiHariIni->update([
                'id_status_co'     => $statusDbCo->id_status_presensi,
                'jam_pulang'       => $jamSekarang,
                'foto_pulang'      => $fileName,
                'latitude_pulang'  => $request->latitude,
                'longitude_pulang' => $request->longitude,
            ]);

            $pesan = ($statusNameCo == 'Lupa Check-Out') ? 'Anda lewat jam 18.00, tercatat sebagai Lupa Check-Out. Silakan ajukan klaim.' : 'Presensi Pulang Berhasil dicatat! Hati-hati di jalan.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $pesan,
            'redirect' => $role == 'tendik' ? route('tendik.dashboard') : route('siswa.dashboard')
        ]);
    }
}
