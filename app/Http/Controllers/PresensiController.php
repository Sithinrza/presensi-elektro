<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\StatusPresensi;
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
        $jamSekarang = $waktuSekarang->format('H:i:s');
        $hariIniIso = $waktuSekarang->dayOfWeekIso;

        // =========================================================================
        // CEK STATUS AKUN NONAKTIF
        // =========================================================================
        $statusAkun = 'aktif';
        if ($role == 'tendik') {
            $dataTendik = \App\Models\Tendik::where('id_user', $user->id_user)->first();
            $statusAkun = $dataTendik->status ?? 'aktif';
        } elseif ($role == 'siswa' || $role == 'siswa magang') {
            $dataSiswa = \App\Models\SiswaMagang::where('id_user', $user->id_user)->first();
            $statusAkun = $dataSiswa->status ?? 'aktif';
        }

        $isNonaktif = false;
        if (strtolower($statusAkun) == 'nonaktif') {
            $isNonaktif = true;
        }

        // =========================================================================
        // CEK "DOSA MASA LALU" (Lupa CO dan Belum Isi Alasan)
        // =========================================================================
        $statusLupaCO = StatusPresensi::where('name', 'Lupa Check-Out')->first();
        $presensiGantung = null;

        if ($statusLupaCO) {
            $presensiGantung = Presensi::where('id_user', $user->id_user)
                                       ->where('id_status_co', $statusLupaCO->id_status_presensi)
                                       ->whereNull('alasan')
                                       ->orderBy('tanggal', 'asc')
                                       ->first();
        }

        // --- 1. CEK HARI LIBUR & AKHIR PEKAN ---
        $isWeekend = in_array($hariIniIso, [6, 7]);

        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();

        // --- 2. CEK JAM BUKA SISTEM ---
        $belumBuka = $jamSekarang < '06:00:00';

        $presensiHariIni = Presensi::with(['statusCi', 'statusCo'])
                                   ->where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        // --- 3. CEK LEWAT JAM CO UNTUK YANG BOLOS TOTAL ---
        $lewatJamCo = false;
        if (!$presensiHariIni) {
            $batasBatasCo = ($hariIniIso == 5) ? '17:30:00' : '17:00:00';
            if ($jamSekarang > $batasBatasCo) {
                $lewatJamCo = true;
            }
        }

        $presensiSelesai = $presensiHariIni && $presensiHariIni->jam_pulang != null;
        $belumWaktunyaPulang = false;
        $jadwalPulang = '16:00';

        if ($presensiHariIni && !$presensiSelesai) {
            if ($hariIniIso == 5) {
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

        return view('presensi.index', compact('layout', 'backUrl', 'role', 'url_dashboard', 'presensiHariIni', 'presensiSelesai', 'belumWaktunyaPulang', 'jadwalPulang', 'hariLiburIni', 'isWeekend', 'belumBuka', 'lewatJamCo', 'presensiGantung', 'isNonaktif'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);

        $statusAkun = 'aktif';
        if ($role == 'tendik') {
            $dataTendik = \App\Models\Tendik::where('id_user', $user->id_user)->first();
            $statusAkun = $dataTendik->status ?? 'aktif';
        } elseif ($role == 'siswa' || $role == 'siswa magang') {
            $dataSiswa = \App\Models\SiswaMagang::where('id_user', $user->id_user)->first();
            $statusAkun = $dataSiswa->status ?? 'aktif';
        }

        if (strtolower($statusAkun) == 'nonaktif') {
            return response()->json(['status' => 'error', 'message' => 'Akun Anda berstatus Nonaktif. Presensi dihentikan.']);
        }

        $request->validate([
            'image_base64' => 'required',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
        ]);

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');
        $jamSekarang = $waktuSekarang->format('H:i:s');
        $hariIniIso = $waktuSekarang->dayOfWeekIso;

        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();

        if ($hariLiburIni) {
            return response()->json(['status' => 'error', 'message' => 'Sistem ditutup! Hari ini libur: ' . $hariLiburIni->nama_libur]);
        }

        if (in_array($hariIniIso, [6, 7])) {
            return response()->json(['status' => 'error', 'message' => 'Sistem presensi dinonaktifkan pada akhir pekan (Sabtu & Minggu).']);
        }

        if ($jamSekarang < '06:00:00') {
            return response()->json(['status' => 'error', 'message' => 'Sistem presensi baru dibuka pukul 06:00 WITA.']);
        }

        $img = $request->image_base64;
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);

        $fileName = $user->id_user . '_' . $tanggalHariIni . '_' . time() . '.jpeg';
        Storage::disk('public')->put('presensi/' . $fileName, $image_base64);

        $presensiHariIni = Presensi::with('statusCi')
                                   ->where('id_user', $user->id_user)
                                   ->where('tanggal', $tanggalHariIni)
                                   ->first();

        // ================= LOGIKA AMBIL ABSEN MASUK (CHECK-IN) =================
        if (!$presensiHariIni) {

            $batasBatasCo = ($hariIniIso == 5) ? '17:30:00' : '17:00:00';
            if ($jamSekarang > $batasBatasCo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Waktu presensi hari ini telah berakhir. Anda tidak dapat melakukan absen masuk lagi dan tercatat Alpa.'
                ]);
            }

            $batasHadir = Carbon::createFromTime(8, 0, 0, 'Asia/Makassar');
            $batasTelat = Carbon::createFromTime(8, 30, 0, 'Asia/Makassar');

            if ($waktuSekarang->greaterThan($batasTelat)) {
                $statusNameCi = 'Alpa';
            } elseif ($waktuSekarang->greaterThan($batasHadir)) {
                $statusNameCi = 'Terlambat';
            } else {
                $statusNameCi = 'Tepat Waktu';
            }

            $statusDbCi = StatusPresensi::where('name', $statusNameCi)->first();
            if (!$statusDbCi) return response()->json(['status' => 'error', 'message' => 'Status presensi CI tidak ditemukan!']);

            Presensi::create([
                'id_user'            => $user->id_user,
                'id_status_ci'       => $statusDbCi->id_status_presensi,
                'tanggal'            => $tanggalHariIni,
                'jam_masuk'          => $jamSekarang,
                'foto_masuk'         => $fileName,
                'latitude_masuk'     => $request->latitude,
                'longitude_masuk'    => $request->longitude,
            ]);

            $pesan = ($statusNameCi == 'Alpa') ? 'Anda absen terlalu siang, status dicatat sebagai Alpa.' : 'Presensi Masuk Berhasil dicatat!';

        // ================= LOGIKA AMBIL ABSEN PULANG (CHECK-OUT) =================
        } else {
            if ($presensiHariIni->jam_pulang != null) {
                return response()->json(['status' => 'error', 'message' => 'Anda sudah melakukan presensi pulang hari ini!']);
            }

            if ($hariIniIso == 5) {
                $batasPulang = Carbon::createFromTime(16, 30, 0, 'Asia/Makassar');
                $batasTerlambatCo = Carbon::createFromTime(17, 30, 0, 'Asia/Makassar');
            } else {
                $batasPulang = Carbon::createFromTime(16, 0, 0, 'Asia/Makassar');
                $batasTerlambatCo = Carbon::createFromTime(17, 0, 0, 'Asia/Makassar');
            }

            if ($waktuSekarang->lessThan($batasPulang)) {
                return response()->json(['status' => 'error', 'message' => 'Belum waktunya pulang!']);
            }

            if ($presensiHariIni->statusCi && $presensiHariIni->statusCi->name == 'Alpa') {
                $statusNameCo = 'Alpa';
                $pesan = 'Presensi Pulang dicatat. Status tetap Alpa karena absen masuk Anda terlambat parah.';
            } else {
                if ($waktuSekarang->greaterThan($batasTerlambatCo)) {
                    $statusNameCo = 'Terlambat CO';
                    $pesan = 'Presensi Pulang Berhasil! Namun Anda terlambat melakukan Check-Out.';
                } else {
                    $statusNameCo = 'Check Out';
                    $pesan = 'Presensi Pulang Berhasil dicatat! Hati-hati di jalan.';
                }
            }

            $statusDbCo = StatusPresensi::where('name', $statusNameCo)->first();
            if (!$statusDbCo) return response()->json(['status' => 'error', 'message' => 'Status presensi CO tidak ditemukan!']);

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

    public function simpanAlasan(Request $request)
    {
        $request->validate([
            'id_presensi' => 'required|exists:presensi,id_presensi',
            'alasan'      => 'required|string|min:5'
        ], [
            'alasan.required' => 'Alasan tidak boleh kosong!',
            'alasan.min'      => 'Alasan terlalu singkat, mohon jelaskan lebih detail.'
        ]);

        $presensi = Presensi::where('id_presensi', $request->id_presensi)
                            ->where('id_user', Auth::user()->id_user)
                            ->firstOrFail();

        $presensi->update([
            'alasan' => $request->alasan
        ]);

        // PERBAIKAN: Setelah simpan, lempar ke dashboard masing-masing!
        // Biar bisa melek dan lihat status kameranya apakah sudah bisa dibuka.
        $role = strtolower(Auth::user()->roles->first()->name);

        if ($role == 'tendik') {
            return redirect()->route('tendik.dashboard')->with('success', 'Alasan lupa Check-Out berhasil disimpan!');
        } else {
            return redirect()->route('siswa.dashboard')->with('success', 'Alasan lupa Check-Out berhasil disimpan!');
        }
    }
}
