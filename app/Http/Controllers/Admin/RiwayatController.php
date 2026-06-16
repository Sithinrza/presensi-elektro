<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use App\Models\StatusPresensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now('Asia/Makassar')->format('Y-m-d');

        $presensiHariIni = Presensi::with(['statusCi', 'statusCo'])
                                   ->whereDate('tanggal', $hariIni)
                                   ->get()
                                   ->keyBy('id_user');

        // PERBAIKAN: Libur akhir pekan mencakup Sabtu (6) dan Minggu (7)
        $isLiburMingguan = in_array(Carbon::now('Asia/Makassar')->dayOfWeekIso, [6, 7]);
        $liburNasional = \App\Models\HariLibur::whereDate('tanggal_mulai', '<=', $hariIni)
                                              ->whereDate('tanggal_selesai', '>=', $hariIni)
                                              ->exists();
        $isLiburHariIni = $isLiburMingguan || $liburNasional;

        $siswa = SiswaMagang::with('user')->get()->map(function ($s) use ($presensiHariIni, $isLiburHariIni) {
            $status = 'Belum Presensi';
            if ($presensiHariIni->has($s->id_user)) {
                $p = $presensiHariIni->get($s->id_user);
                $status = $p->statusCi ? $p->statusCi->name : 'Belum Hadir';
            } elseif ($isLiburHariIni) {
                $status = 'Libur';
            }
            $s->status_hari_ini = $status;
            return $s;
        });

        $tendik = Tendik::with(['user', 'unitKerja'])->get()->map(function ($t) use ($presensiHariIni, $isLiburHariIni) {
            $status = 'Belum Presensi';
            if ($presensiHariIni->has($t->id_user)) {
                $p = $presensiHariIni->get($t->id_user);
                $status = $p->statusCi ? $p->statusCi->name : 'Belum Hadir';
            } elseif ($isLiburHariIni) {
                $status = 'Libur';
            }
            $t->status_hari_ini = $status;
            return $t;
        });

        return view('admin.riwayat-presensi.index', compact('siswa', 'tendik'));
    }

    public function showDetail(Request $request, $id_user)
    {
        $user = \App\Models\User::with(['siswaMagang', 'tendik'])->findOrFail($id_user);

        $nama_lengkap = 'User Tidak Diketahui';
        $role = 'Tidak Diketahui';
        $instansi = '-';
        $foto_profil = null;

        if ($user->siswaMagang) {
            $nama_lengkap = $user->siswaMagang->nama_lengkap;
            $role = 'Siswa Magang';
            $instansi = $user->siswaMagang->sekolah_asal;
            $foto_profil = $user->siswaMagang->foto_profil;
        } elseif ($user->tendik) {
            $nama_lengkap = $user->tendik->nama_lengkap;
            $role = 'Tenaga Kependidikan';
            $instansi = $user->tendik->unitKerja ? $user->tendik->unitKerja->nama_unit : '-';
            $foto_profil = $user->tendik->foto_profil;
        }

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        // PERBAIKAN: Set Timezone Asia/Makassar agar batas loop sinkron dengan $waktuSekarang
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Makassar')->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // PERBAIKAN: Set Timezone
        $tanggalBikinAkun = Carbon::parse($user->created_at)->timezone('Asia/Makassar')->startOfDay();
        $mulaiLoop = $startOfMonth->copy()->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->copy()->startOfDay() : $endOfMonth->copy();

        $dbRiwayat = Presensi::with(['statusCi', 'statusCo'])
                    ->where('id_user', $id_user)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get()
                    ->keyBy('tanggal');

        $hariLibur = \App\Models\HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayat = collect();

        $statistik = [
            'Tepat CI' => 0, 'Telat CI' => 0, 'Alpa' => 0,
            'Tepat CO' => 0, 'Telat CO' => 0, 'Lupa CO' => 0, 'Libur' => 0
        ];

        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            if ($dbRiwayat->has($dateString)) {
                $p = $dbRiwayat->get($dateString);

                if ($dateString != $waktuSekarang->format('Y-m-d') && !is_null($p->jam_masuk) && is_null($p->jam_pulang)) {
                    $statusLupa = new StatusPresensi(['name' => 'Lupa Check-Out']);
                    $p->setRelation('statusCo', $statusLupa);
                }

                $riwayat->push($p);

                if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') $statistik['Tepat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Terlambat') $statistik['Telat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Alpa') $statistik['Alpa']++;
                if ($p->statusCi && $p->statusCi->name == 'Libur') $statistik['Libur']++;

                if ($p->statusCo && in_array($p->statusCo->name, ['Tepat Waktu', 'Check Out'])) $statistik['Tepat CO']++;
                if ($p->statusCo && $p->statusCo->name == 'Terlambat CO') $statistik['Telat CO']++;
                if ($p->statusCo && $p->statusCo->name == 'Lupa Check-Out') $statistik['Lupa CO']++;
            } else {
                if ($date->lte($batasLoop)) {
                    // PERBAIKAN: Libur akhir pekan mencakup Sabtu (6) dan Minggu (7)
                    $isLibur = in_array($date->dayOfWeekIso, [6, 7]);
                    foreach ($hariLibur as $hl) {
                        // Memastikan filter libur spesifik sesuai timezone
                        if ($date->between(Carbon::parse($hl->tanggal_mulai, 'Asia/Makassar')->startOfDay(), Carbon::parse($hl->tanggal_selesai, 'Asia/Makassar')->endOfDay())) {
                            $isLibur = true; break;
                        }
                    }

                    if ($isLibur) {
                        $statistik['Libur']++;
                        $statusMock = new StatusPresensi(['name' => 'Libur']);
                    } else {
                        // CEK JIKA HARI INI DAN MASIH SEBELUM JAM 08:30
                        $jamSekarang = Carbon::now('Asia/Makassar')->format('H:i:s');

                        if ($dateString === $waktuSekarang->format('Y-m-d') && $jamSekarang < '08:30:00') {
                            // Jangan hitung sebagai Alpa di statistik, dan set status Belum presensi
                            $statusMock = new StatusPresensi(['name' => 'Belum Presensi']);
                        } else {
                            $statistik['Alpa']++;
                            $statusMock = new StatusPresensi(['name' => 'Alpa']);
                        }
                    }

                    $mock = new Presensi(['tanggal' => $dateString, 'jam_masuk' => null, 'jam_pulang' => null]);
                    $mock->setRelation('statusCi', $statusMock);
                    $mock->setRelation('statusCo', $statusMock);
                    $riwayat->push($mock);
                }
            }
        }

        $riwayat = $riwayat->sortByDesc('tanggal')->values();

        return view('admin.riwayat-presensi.show', compact(
            'riwayat', 'statistik', 'nama_lengkap', 'role', 'instansi', 'foto_profil', 'bulan', 'tahun', 'id_user'
        ));
    }

    public function cetakPdf(Request $request, $id_user)
    {
        $user = \App\Models\User::with(['siswaMagang', 'tendik'])->findOrFail($id_user);

        $role = 'Tidak Diketahui';
        $nama_lengkap = 'User Tidak Diketahui';
        $instansi = '-';

        if ($user->siswaMagang) {
            $nama_lengkap = $user->siswaMagang->nama_lengkap;
            $role = 'Siswa Magang';
            $instansi = $user->siswaMagang->sekolah_asal;
        } elseif ($user->tendik) {
            $nama_lengkap = $user->tendik->nama_lengkap;
            $role = 'Tenaga Kependidikan';
            $instansi = $user->tendik->unitKerja ? $user->tendik->unitKerja->nama_unit : '-';
        }

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        // PERBAIKAN TIMEZONE
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Makassar')->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $tanggalBikinAkun = Carbon::parse($user->created_at)->timezone('Asia/Makassar')->startOfDay();
        $mulaiLoop = $startOfMonth->copy()->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->copy()->startOfDay() : $endOfMonth->copy();

        $dbRiwayat = Presensi::with(['statusCi', 'statusCo'])
                    ->where('id_user', $id_user)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get()
                    ->keyBy('tanggal');

        $hariLibur = \App\Models\HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayat = collect();

        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            if ($dbRiwayat->has($dateString)) {
                $p = $dbRiwayat->get($dateString);

                if ($dateString != $waktuSekarang->format('Y-m-d') && !is_null($p->jam_masuk) && is_null($p->jam_pulang)) {
                    $p->setRelation('statusCo', new StatusPresensi(['name' => 'Lupa Check-Out']));
                }

                $riwayat->push($p);
            } else {
                if ($date->lte($batasLoop)) {
                    // PERBAIKAN SABTU & MINGGU
                    $isLibur = in_array($date->dayOfWeekIso, [6, 7]);
                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai, 'Asia/Makassar')->startOfDay(), Carbon::parse($hl->tanggal_selesai, 'Asia/Makassar')->endOfDay())) {
                            $isLibur = true; break;
                        }
                    }

                    if ($isLibur) {
                        $statusMock = new StatusPresensi(['name' => 'Libur']);
                    } else {
                        // CEK JIKA HARI INI DAN MASIH SEBELUM JAM 08:30
                        $jamSekarang = Carbon::now('Asia/Makassar')->format('H:i:s');

                        if ($dateString === $waktuSekarang->format('Y-m-d') && $jamSekarang < '08:30:00') {
                            $statusMock = new StatusPresensi(['name' => 'Belum Presensi']);
                        } else {
                            $statusMock = new StatusPresensi(['name' => 'Alpa']);
                        }
                    }

                    $mock = new Presensi(['tanggal' => $dateString, 'jam_masuk' => null, 'jam_pulang' => null]);
                    $mock->setRelation('statusCi', $statusMock);
                    $mock->setRelation('statusCo', $statusMock);
                    $riwayat->push($mock);
                }
            }
        }

        $riwayat = $riwayat->sortBy('tanggal')->values();

        $profil = (object)[
            'nama_lengkap' => $nama_lengkap,
            'sekolah_asal' => $instansi,
            'role' => $role
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.riwayat-presensi.cetak', [
            'siswa' => $profil,
            'riwayat' => $riwayat,
            'periode' => Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y')
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Presensi-'.$nama_lengkap.'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $kategori = $request->kategori ?? 'siswa';

        // PERBAIKAN TIMEZONE
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1, 'Asia/Makassar')->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $waktuSekarang = Carbon::now('Asia/Makassar');

        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->copy()->startOfDay() : $endOfMonth->copy();

        $users = ($kategori == 'siswa') ? \App\Models\SiswaMagang::with('user')->get() : \App\Models\Tendik::with(['user', 'unitKerja'])->get();
        $idUsers = $users->pluck('id_user')->toArray();

        $presensiAll = Presensi::with(['statusCi', 'statusCo'])
                        ->whereIn('id_user', $idUsers)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->get()
                        ->groupBy('id_user');

        $hariLibur = \App\Models\HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $hariInMonth = [];
        for ($d = $startOfMonth->copy(); $d->lte($endOfMonth); $d->addDay()) { $hariInMonth[] = $d->copy(); }

        $laporan = [];

        foreach ($users as $u) {
            $presensiUser = $presensiAll->has($u->id_user) ? $presensiAll->get($u->id_user)->keyBy('tanggal') : collect();

            $row = [
                'nama' => $u->nama_lengkap,
                'identitas' => $kategori == 'siswa' ? ($u->nis ?? '-') : ($u->nip ?? '-'),
                'instansi' => $kategori == 'siswa' ? ($u->sekolah_asal ?? '-') : ($u->unitKerja->nama_unit ?? '-'),
                'rekap_ci' => [],
                'rekap_co' => [],
                'ci_tepat' => 0, 'ci_telat' => 0, 'ci_alpa' => 0, 'ci_libur' => 0,
                'co_tepat' => 0, 'co_telat' => 0, 'co_lupa' => 0,
            ];

            foreach ($hariInMonth as $date) {
                $dateString = $date->format('Y-m-d');
                $simbol_ci = '';
                $simbol_co = '';

                if ($presensiUser->has($dateString)) {
                    $p = $presensiUser->get($dateString);

                    if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') { $simbol_ci = 'TW'; $row['ci_tepat']++; }
                    elseif ($p->statusCi && $p->statusCi->name == 'Terlambat') { $simbol_ci = 'T'; $row['ci_telat']++; }
                    elseif ($p->statusCi && $p->statusCi->name == 'Libur') { $simbol_ci = 'L'; $row['ci_libur']++; }
                    else { $simbol_ci = 'A'; $row['ci_alpa']++; }

                    if ($dateString != $waktuSekarang->format('Y-m-d') && !is_null($p->jam_masuk) && is_null($p->jam_pulang)) {
                        $simbol_co = 'LC'; $row['co_lupa']++;
                    } elseif ($p->statusCo) {
                        if (in_array($p->statusCo->name, ['Tepat Waktu', 'Check Out'])) { $simbol_co = 'CO'; $row['co_tepat']++; }
                        elseif ($p->statusCo->name == 'Terlambat CO') { $simbol_co = 'TC'; $row['co_telat']++; }
                        elseif ($p->statusCo->name == 'Lupa Check-Out') { $simbol_co = 'LC'; $row['co_lupa']++; }
                        elseif ($p->statusCo->name == 'Libur') { $simbol_co = 'L'; }
                        else { $simbol_co = '-'; }
                    } else {
                        $simbol_co = '-';
                    }

                } else {
                    if ($date->lte($batasLoop)) {
                        // PERBAIKAN SABTU & MINGGU
                        $isLibur = in_array($date->dayOfWeekIso, [6, 7]);
                        foreach ($hariLibur as $hl) {
                            if ($date->between(Carbon::parse($hl->tanggal_mulai, 'Asia/Makassar')->startOfDay(), Carbon::parse($hl->tanggal_selesai, 'Asia/Makassar')->endOfDay())) {
                                $isLibur = true; break;
                            }
                        }

                        if ($isLibur) {
                            $simbol_ci = 'L'; $row['ci_libur']++;
                            $simbol_co = 'L';
                        } else {
                            // CEK JIKA HARI INI DAN MASIH SEBELUM JAM 08:30
                            $jamSekarang = Carbon::now('Asia/Makassar')->format('H:i:s');

                            if ($dateString === $waktuSekarang->format('Y-m-d') && $jamSekarang < '08:30:00') {
                                // Kasih strip (-) biar Excelnya kosong/putih, dan jangan tambah hitungan Alpa
                                $simbol_ci = '-';
                                $simbol_co = '-';
                            } else {
                                $simbol_ci = 'A'; $row['ci_alpa']++;
                                $simbol_co = 'A';
                            }
                        }
                    }
                }

                $row['rekap_ci'][$dateString] = $simbol_ci;
                $row['rekap_co'][$dateString] = $simbol_co;
            }
            $laporan[] = $row;
        }

        return view('admin.riwayat-presensi.excel', compact('laporan', 'hariInMonth', 'bulan', 'tahun', 'kategori'));
    }
}
