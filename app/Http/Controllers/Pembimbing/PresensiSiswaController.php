<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\SiswaMagang;
use App\Models\Pembimbing;
use App\Models\Presensi;
use App\Models\HariLibur;
use App\Models\StatusPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $pembimbing = Pembimbing::where('id_user', Auth::id())->first();

        // 1. Ambil data siswa
        $query = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing)
                            ->with('user')
                            ->orderBy('status', 'asc') 
                            ->orderBy('nama_lengkap', 'asc');

        if ($request->has('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $anakBimbingan = $query->get();
        $idUsers = $anakBimbingan->pluck('id_user')->toArray();

        // 2. Setup Waktu Bulan Ini (Wajib Asia/Makassar)
        $bulan = date('m');
        $tahun = date('Y');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Makassar')->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $todayString = $waktuSekarang->format('Y-m-d');

        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->copy()->startOfDay() : $endOfMonth->copy();

        // 3. Ambil semua presensi siswa asuhan bulan ini sekaligus
        $presensiBulanIni = Presensi::with(['statusCi', 'statusCo'])
            ->whereIn('id_user', $idUsers)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('id_user');

        $hariLibur = HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        // 4. Hitung Statistik Real-time Akurat untuk Setiap Siswa
        foreach ($anakBimbingan as $s) {
            $s->stat_tepat_ci = 0; $s->stat_telat_ci = 0; $s->stat_alpa = 0;
            $s->stat_tepat_co = 0; $s->stat_telat_co = 0; $s->stat_lupa_co = 0;

            // PERBAIKAN 1: Pengambilan Collection anti-mismatch
            $presensiSiswa = isset($presensiBulanIni[$s->id_user])
                ? collect($presensiBulanIni[$s->id_user])->keyBy(function($item) {
                    return Carbon::parse($item->tanggal)->format('Y-m-d');
                })
                : collect();

            $tanggalBikinAkun = Carbon::parse($s->user->created_at ?? $s->created_at)->timezone('Asia/Makassar')->startOfDay();
            $mulaiLoop = $startOfMonth->copy()->max($tanggalBikinAkun);

            for ($date = $mulaiLoop->copy(); $date->lte($batasLoop); $date->addDay()) {
                $dateString = $date->format('Y-m-d');

                // Jika ADA data presensi
                // Jika ADA data presensi
                if ($presensiSiswa->has($dateString)) {
                    $p = $presensiSiswa->get($dateString);

                    if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') $s->stat_tepat_ci++;
                    elseif ($p->statusCi && $p->statusCi->name == 'Terlambat') $s->stat_telat_ci++;
                    elseif ($p->statusCi && $p->statusCi->name == 'Alpa') $s->stat_alpa++;

                    // =======================================================
                    // PERBAIKAN: JIKA ALPA CI = MAKA JANGAN DIHITUNG LUPA CO
                    // =======================================================
                    if ($p->statusCi && $p->statusCi->name == 'Alpa') {
                        // Jangan hitung apa-apa untuk CO, biarkan saja
                    }
                    elseif ($dateString != $todayString && !is_null($p->jam_masuk) && is_null($p->jam_pulang)) {
                        $s->stat_lupa_co++;
                    } elseif ($p->statusCo) {
                        if (in_array($p->statusCo->name, ['Tepat Waktu', 'Check Out'])) $s->stat_tepat_co++;
                        elseif ($p->statusCo->name == 'Terlambat CO') $s->stat_telat_co++;
                        elseif ($p->statusCo->name == 'Lupa Check-Out') $s->stat_lupa_co++;
                    }
                }
                // Jika KOSONG (Cek Akhir Pekan & Hari Libur)
                else {
                    // PERBAIKAN 2: 6 = Sabtu, 7 = Minggu
                    $isLibur = in_array($date->dayOfWeekIso, [6, 7]);

                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                            $isLibur = true; break;
                        }
                    }

                    if (!$isLibur) {
                        $s->stat_alpa++;
                    }
                }
            }
        }

        return view('pembimbing.presensi-siswa.index', compact('anakBimbingan'));
    }

    public function show(Request $request, $id_user)
    {
        $siswa = SiswaMagang::where('id_user', $id_user)->firstOrFail();

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $todayString = $waktuSekarang->format('Y-m-d');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Makassar')->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $tanggalBikinAkun = Carbon::parse($siswa->created_at)->timezone('Asia/Makassar')->startOfDay();
        $mulaiLoop = $startOfMonth->copy()->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->copy()->startOfDay() : $endOfMonth->copy();

        $dbRiwayat = Presensi::with(['statusCi', 'statusCo'])
                             ->where('id_user', $id_user)
                             ->whereMonth('tanggal', $bulan)
                             ->whereYear('tanggal', $tahun)
                             ->get()
                             ->keyBy(function($item) {
                                 return Carbon::parse($item->tanggal)->format('Y-m-d');
                             });

        $hariLibur = HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayatPresensi = collect();
        $statistik = [
            'Tepat CI' => 0, 'Telat CI' => 0, 'Alpa' => 0,
            'Tepat CO' => 0, 'Telat CO' => 0, 'Lupa CO' => 0, 'Libur' => 0
        ];

        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            if ($dbRiwayat->has($dateString)) {
                $p = $dbRiwayat->get($dateString);

                // =======================================================
                // PERBAIKAN: ALPA CI = WAJIB ALPA CO
                // =======================================================
                if ($p->statusCi && $p->statusCi->name == 'Alpa') {
                    $statusAlpaCo = new StatusPresensi(['name' => 'Alpa']);
                    $p->setRelation('statusCo', $statusAlpaCo);
                }
                elseif ($dateString != $todayString && !is_null($p->jam_masuk) && is_null($p->jam_pulang)) {
                    $statusLupa = new StatusPresensi(['name' => 'Lupa Check-Out']);
                    $p->setRelation('statusCo', $statusLupa);
                }

                $riwayatPresensi->push($p);

                if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') $statistik['Tepat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Terlambat') $statistik['Telat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Alpa') $statistik['Alpa']++;
                if ($p->statusCi && $p->statusCi->name == 'Libur') $statistik['Libur']++;

                if ($p->statusCo && in_array($p->statusCo->name, ['Tepat Waktu', 'Check Out'])) $statistik['Tepat CO']++;
                if ($p->statusCo && $p->statusCo->name == 'Terlambat CO') $statistik['Telat CO']++;
                if ($p->statusCo && $p->statusCo->name == 'Lupa Check-Out') $statistik['Lupa CO']++;
            } else {
                if ($date->lte($batasLoop)) {
                    // PERBAIKAN 2: 6 = Sabtu, 7 = Minggu
                    $isLibur = in_array($date->dayOfWeekIso, [6, 7]);

                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                            $isLibur = true; break;
                        }
                    }

                    if ($isLibur) {
                        $statistik['Libur']++;
                        $statusMock = new StatusPresensi(['name' => 'Libur']);
                    } else {
                        // =======================================================
                        // PERBAIKAN: STATUS "BELUM PRESENSI" PAGI HARI
                        // =======================================================
                        $jamSekarang = Carbon::now('Asia/Makassar')->format('H:i:s');

                        if ($dateString === $waktuSekarang->format('Y-m-d') && $jamSekarang < '08:30:00') {
                            $statusMock = new StatusPresensi(['name' => 'Belum Presensi']);
                        } else {
                            $statistik['Alpa']++;
                            $statusMock = new StatusPresensi(['name' => 'Alpa']);
                        }
                    }

                    $mock = new Presensi([
                        'tanggal' => $dateString,
                        'jam_masuk' => null,
                        'jam_pulang' => null
                    ]);
                    $mock->setRelation('statusCi', $statusMock);
                    $mock->setRelation('statusCo', $statusMock);

                    $riwayatPresensi->push($mock);
                }
            }
        }

        $riwayatPresensi = $riwayatPresensi->sortByDesc('tanggal')->values();


        $urlAsal = url()->previous();

        // 2. Deteksi, apakah dia datang dari dashboard?
        if (str_contains($urlAsal, 'dashboard')) {
            $backUrl = route('pembimbing.dashboard');
        } else {
            // Kalau bukan dari dashboard, kembalikan ke halaman index
            $backUrl = route('pembimbing.presensi-siswa.index');
        }

        return view('pembimbing.presensi-siswa.show', compact('siswa', 'riwayatPresensi', 'statistik', 'bulan', 'tahun', 'backUrl'));
    }
}
