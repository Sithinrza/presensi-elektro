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

        $presensiHariIni = Presensi::with('statusPresensi')
                                   ->where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        $presensiSelesai = $presensiHariIni && $presensiHariIni->jam_pulang != null;
        $belumWaktunyaPulang = false;
        $jadwalPulang = '16:00';

        // JIKA SUDAH ABSEN MASUK, TAPI BELUM PULANG
        if ($presensiHariIni && !$presensiSelesai) {
            $hariIni = $waktuSekarang->dayOfWeekIso;

            if ($hariIni == 5) {
                $batasPulang = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar');
                $jadwalPulang = '16:30';
            } else {
                $batasPulang = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
            }

            if ($waktuSekarang->lessThan($batasPulang)) {
                $belumWaktunyaPulang = true;
            }
        }

        // Tentukan Layout & URL
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

        if (!$presensiHariIni) {
            $batasHadir = Carbon::createFromTime(8, 0, 0, 'Asia/Makassar');
            $batasTelat = Carbon::createFromTime(8, 30, 0, 'Asia/Makassar');

            $statusName = 'Hadir';

            // LOGIKA PENCATATAN STATUS TETAP BERJALAN
            if ($waktuSekarang->greaterThan($batasTelat)) {
                $statusName = 'Alfa';
            } elseif ($waktuSekarang->greaterThan($batasHadir)) {
                $statusName = 'Terlambat';
            }

            $statusDb = StatusPresensi::where('name', $statusName)->first();

            if (!$statusDb) {
                return response()->json(['status' => 'error', 'message' => 'Status presensi ' . $statusName . ' tidak ditemukan di database!']);
            }

            Presensi::create([
                'id_user'            => $user->id_user,
                'id_status_presensi' => $statusDb->id_status_presensi,
                'tanggal'            => $tanggalHariIni,
                'jam_masuk'          => $jamSekarang,
                'foto_masuk'         => $fileName,
                'latitude_masuk'     => $request->latitude,
                'longitude_masuk'    => $request->longitude,
            ]);

            $pesan = ($statusName == 'Alfa') ? 'Anda absen terlalu siang, status tercatat sebagai Alfa.' : 'Presensi Masuk Berhasil dicatat!';

        } else {
            if ($presensiHariIni->jam_pulang != null) {
                return response()->json(['status' => 'error', 'message' => 'Anda sudah melakukan presensi pulang hari ini!']);
            }

            $hariIni = $waktuSekarang->dayOfWeekIso;
            $batasPulang = ($hariIni == 5) ? Carbon::createFromTime(16, 30, 0, 'Asia/Makassar') : Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');

            if ($waktuSekarang->lessThan($batasPulang)) {
                return response()->json(['status' => 'error', 'message' => 'Belum waktunya pulang!']);
            }

            $presensiHariIni->update([
                'jam_pulang'       => $jamSekarang,
                'foto_pulang'      => $fileName,
                'latitude_pulang'  => $request->latitude,
                'longitude_pulang' => $request->longitude,
            ]);

            $pesan = 'Presensi Pulang Berhasil dicatat! Hati-hati di jalan.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $pesan,
            'redirect' => $role == 'tendik' ? route('tendik.dashboard') : route('siswa.dashboard')
        ]);
    }
}
