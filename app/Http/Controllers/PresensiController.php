<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use App\Models\HariLibur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');

        // --- 1. CEK HARI LIBUR ---
        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();

        $presensiHariIni = Presensi::with(['statusCi', 'statusCo'])
                                   ->where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        $presensiSelesai = $presensiHariIni && $presensiHariIni->jam_pulang != null;
        $belumWaktunyaPulang = false;
        $jadwalPulang = '16:00';

        if ($presensiHariIni && !$presensiSelesai) {
            $hariIni = $waktuSekarang->dayOfWeekIso;

            if ($hariIni == 5) {
                $batasPulang = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar');
                $jadwalPulang = '16:30';
            } else {
                $batasPulang = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
                $jadwalPulang = '16:00';
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

        return view('presensi.index', compact('layout', 'backUrl', 'role', 'url_dashboard', 'presensiHariIni', 'presensiSelesai', 'belumWaktunyaPulang', 'jadwalPulang', 'hariLiburIni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_base64' => 'required',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
        ]);

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');

        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();

        if ($hariLiburIni) {
            return response()->json(['status' => 'error', 'message' => 'Sistem ditutup! Hari ini libur: ' . $hariLiburIni->nama_libur]);
        }

        if ($waktuSekarang->isSunday()) {
            return response()->json(['status' => 'error', 'message' => 'Hari Libur! Sistem presensi dinonaktifkan pada hari Minggu.']);
        }

        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);
        $jamSekarang = $waktuSekarang->format('H:i:s');

        $img = $request->image_base64;
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);

        $fileName = $user->id_user . '_' . $tanggalHariIni . '_' . time() . '.jpeg';

        // PERUBAHAN STORAGE: Simpan foto langsung ke storage/app/public/presensi
        Storage::disk('public')->put('presensi/' . $fileName, $image_base64);

        $presensiHariIni = Presensi::where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        // ================= LOGIKA AMBIL ABSEN MASUK (CHECK-IN) =================
        if (!$presensiHariIni) {
            $batasHadir = Carbon::createFromTime(8, 0, 0, 'Asia/Makassar');
            $batasTelat = Carbon::createFromTime(8, 30, 0, 'Asia/Makassar');

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

        // ================= LOGIKA AMBIL ABSEN PULANG (CHECK-OUT) =================
        } else {
            if ($presensiHariIni->jam_pulang != null) {
                return response()->json(['status' => 'error', 'message' => 'Anda sudah melakukan presensi pulang hari ini!']);
            }

            $hariIni = $waktuSekarang->dayOfWeekIso;

            // Aturan Jam Pulang Tegas (Senin-Kamis 16:00 - 17:00, Jumat 16:30 - 17:30)
            if ($hariIni == 5) {
                $batasPulang = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar');
                $batasTerlambatCo = Carbon::createFromTime(17, 30, 0, 'Asia/Makassar');
            } else {
                $batasPulang = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
                $batasTerlambatCo = Carbon::createFromTime(17, 0, 0, 'Asia/Makassar');
            }

            if ($waktuSekarang->lessThan($batasPulang)) {
                return response()->json(['status' => 'error', 'message' => 'Belum waktunya pulang!']);
            }

            // Jika lewat jam 5 sore di hari yang sama, maka Terlambat CO.
            // Lupa CO tidak dicek di sini, karena kalau sudah ganti hari, logic larinya ke Check-In.
            if ($waktuSekarang->greaterThan($batasTerlambatCo)) {
                $statusNameCo = 'Terlambat CO';
                $pesan = 'Presensi Pulang Berhasil! Namun Anda terlambat melakukan Check-Out.';
            } else {
                $statusNameCo = 'Check Out';
                $pesan = 'Presensi Pulang Berhasil dicatat! Hati-hati di jalan.';
            }

            $statusDbCo = StatusPresensi::where('name', $statusNameCo)->first();

            if (!$statusDbCo) {
                return response()->json(['status' => 'error', 'message' => 'Status presensi CO tidak ditemukan!']);
            }

            $presensiHariIni->update([
                'id_status_co'     => $statusDbCo->id_status_presensi,
                'jam_pulang'       => $jamSekarang,
                'foto_pulang'      => $fileName,
                'latitude_pulang'  => $request->latitude,
                'longitude_pulang' => $request->longitude,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => $pesan,
            'redirect' => $role == 'tendik' ? route('tendik.dashboard') : route('siswa.dashboard')
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);

        $query = Presensi::with(['statusCi', 'statusCo'])->where('id_presensi', $id);

        if ($role !== 'admin' && $role !== 'pembimbing') {
            $query->where('id_user', $user->id_user);
        }

        $presensi = $query->firstOrFail();

        if ($role == 'admin') {
            $layout = 'layouts.admin';
            $backUrl = route('admin.riwayat.detail', $presensi->id_user);
        } elseif ($role == 'pembimbing') {
            $layout = 'layouts.pembimbing';
            $backUrl = route('pembimbing.presensi-siswa.show', $presensi->id_user);
        } elseif ($role == 'tendik') {
            $layout = 'layouts.tendik';
            $backUrl = route('presensi.riwayat-presensi');
        } else {
            $layout = 'layouts.siswa';
            $backUrl = route('presensi.riwayat-presensi');
        }

        return view('presensi.show', compact('layout', 'backUrl', 'presensi'));
    }
}
