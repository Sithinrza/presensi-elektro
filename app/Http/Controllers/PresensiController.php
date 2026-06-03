<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use App\Models\KlaimPresensi;
use App\Models\HariLibur;
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

            // Atur batas minimal pulang berdasarkan hari (Jumat jam 16:30, Senin-Kamis jam 16:00)
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

        // PROTEKSI SERVER 1: Tolak presensi jika hari libur (dari database)
        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();

        if ($hariLiburIni) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sistem ditutup! Hari ini libur: ' . $hariLiburIni->nama_libur
            ]);
        }

        // PROTEKSI SERVER 2: Tolak presensi jika hari Minggu (otomatis)
        if ($waktuSekarang->isSunday()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hari Libur! Sistem presensi dinonaktifkan pada hari Minggu.'
            ]);
        }

        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);
        $jamSekarang = $waktuSekarang->format('H:i:s');

        // Memecah dan mendecode gambar base64 dari canvas
        $img = $request->image_base64;
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);

        $fileName = $user->id_user . '_' . $tanggalHariIni . '_' . time() . '.jpeg';

        // Simpan fotonya
        $folderPath = public_path('uploads/presensi');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
        file_put_contents($folderPath . '/' . $fileName, $image_base64);

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

            // Tentukan konfigurasi jam kerja berdasarkan hari
            if ($hariIni == 5) { // Hari Jumat
                $batasPulang = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar'); // Batas minimal CO
                $batasTerlambatCo = Carbon::createFromTime(17, 0, 0, 'Asia/Makassar'); // Toleransi CO 30 Menit
            } else { // Hari Senin - Kamis
                $batasPulang = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
                $batasTerlambatCo = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar');
            }

            // Tolak jika belum waktunya pulang
            if ($waktuSekarang->lessThan($batasPulang)) {
                return response()->json(['status' => 'error', 'message' => 'Belum waktunya pulang!']);
            }

            // Tentukan status kelulusan check-out
            if ($waktuSekarang->greaterThan($batasTerlambatCo)) {
                $statusNameCo = 'Lupa Check-Out';
                $pesan = 'Anda melewati batas toleransi check-out, status tercatat sebagai Lupa Check-Out. Silakan ajukan klaim.';
            } elseif ($waktuSekarang->greaterThan($batasPulang)) {
                $statusNameCo = 'Terlambat CO';
                $pesan = 'Presensi Pulang Berhasil dicatat! Namun Anda terlambat melakukan Check-Out.';
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

    public function ajukanKlaim(Request $request)
    {
        $request->validate([
            'id_presensi' => 'required|exists:presensi,id_presensi',
            'alasan' => 'required|string',
            'dokumen_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('dokumen_bukti')) {
            $file = $request->file('dokumen_bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads/klaim', $fileName);
        }

        KlaimPresensi::create([
            'id_presensi' => $request->id_presensi,
            'alasan' => $request->alasan,
            'dokumen_bukti' => $fileName,
            'status_verifikasi' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Klaim berhasil diajukan dan menunggu verifikasi admin.');
    }
}
