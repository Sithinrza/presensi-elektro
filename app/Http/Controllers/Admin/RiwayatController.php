<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::now('Asia/Makassar')->format('Y-m-d');

        // 1. Ambil semua data presensi hari ini dalam satu query (Optimasi agar tidak lemot)
        $presensiHariIni = Presensi::with('statusCi')
                                   ->whereDate('tanggal', $hariIni)
                                   ->get()
                                   ->keyBy('id_user');

        // 2. Cek apakah hari ini bertepatan dengan hari libur nasional atau hari Minggu
        $isMinggu = Carbon::now('Asia/Makassar')->isSunday();
        $liburNasional = \App\Models\HariLibur::whereDate('tanggal_mulai', '<=', $hariIni)
                                              ->whereDate('tanggal_selesai', '>=', $hariIni)
                                              ->exists();
        $isLiburHariIni = $isMinggu || $liburNasional;

        // 3. Map status kehadiran hari ini untuk Siswa
        $siswa = SiswaMagang::with('user')->get()->map(function ($s) use ($presensiHariIni, $isLiburHariIni) {
            $status = 'Belum Hadir';
            if ($presensiHariIni->has($s->id_user)) {
                $p = $presensiHariIni->get($s->id_user);
                $status = $p->statusCi ? $p->statusCi->name : 'Belum Hadir';
            } elseif ($isLiburHariIni) {
                $status = 'Libur';
            }
            $s->status_hari_ini = $status;
            return $s;
        });

        // 4. Map status kehadiran hari ini untuk Tendik
        $tendik = Tendik::with(['user', 'unitKerja'])->get()->map(function ($t) use ($presensiHariIni, $isLiburHariIni) {
            $status = 'Belum Hadir';
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
        // 1. Ambil data User beserta relasi profilnya
        $user = \App\Models\User::with(['siswaMagang', 'tendik'])->findOrFail($id_user);

        $nama_lengkap = 'User Tidak Diketahui';
        $role = 'Tidak Diketahui';
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

        // 2. Filter Bulan & Tahun
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $tanggalBikinAkun = Carbon::parse($user->created_at)->startOfDay();
        $mulaiLoop = $startOfMonth->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->startOfDay() : $endOfMonth;

        // 3. Ambil data Riwayat Presensi ASLI
        $dbRiwayat = Presensi::with(['statusCi', 'statusCo', 'klaim'])
                    ->where('id_user', $id_user)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get()
                    ->keyBy('tanggal');

        // 4. Ambil kalender Hari Libur
        $hariLibur = \App\Models\HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayat = collect();
        $statistik = [
            'Tepat CI' => 0, 'Telat CI' => 0, 'Alfa' => 0,
            'Tepat CO' => 0, 'Lupa CO' => 0, 'Libur' => 0
        ];

        // 5. ON-THE-FLY GENERATION
        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            if ($dbRiwayat->has($dateString)) {
                $p = $dbRiwayat->get($dateString);
                $riwayat->push($p);

                if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') $statistik['Tepat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Terlambat') $statistik['Telat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Alfa') $statistik['Alfa']++;
                if ($p->statusCi && $p->statusCi->name == 'Libur') $statistik['Libur']++;

                if ($p->statusCo && in_array($p->statusCo->name, ['Tepat Waktu', 'Check Out'])) $statistik['Tepat CO']++;
                if ($p->statusCo && $p->statusCo->name == 'Lupa Check-Out') $statistik['Lupa CO']++;
            } else {
                if ($date->lte($batasLoop)) {
                    $isLibur = $date->isSunday();
                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                            $isLibur = true; break;
                        }
                    }

                    if ($isLibur) {
                        $statistik['Libur']++;
                        $statusMock = new \App\Models\StatusPresensi(['name' => 'Libur']);
                    } else {
                        $statistik['Alfa']++;
                        $statusMock = new \App\Models\StatusPresensi(['name' => 'Alfa']);
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
            'riwayat', 'statistik', 'nama_lengkap', 'role', 'instansi', 'bulan', 'tahun', 'id_user'
        ));
    }

    public function cetakPdf(Request $request, $id_user)
    {
        // 1. Ambil data User (Support untuk Siswa Magang & Tendik)
        $user = \App\Models\User::with(['siswaMagang', 'tendik'])->findOrFail($id_user);

        $nama_lengkap = 'User Tidak Diketahui';
        $instansi = '-';

        if ($user->siswaMagang) {
            $nama_lengkap = $user->siswaMagang->nama_lengkap;
            $instansi = $user->siswaMagang->sekolah_asal;
        } elseif ($user->tendik) {
            $nama_lengkap = $user->tendik->nama_lengkap;
            $instansi = $user->tendik->unitKerja ? $user->tendik->unitKerja->nama_unit : '-';
        }

        // 2. Ambil filter bulan & tahun (Default bulan ini)
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $tanggalBikinAkun = Carbon::parse($user->created_at)->startOfDay();
        $mulaiLoop = $startOfMonth->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->startOfDay() : $endOfMonth;

        // 3. Ambil data Riwayat ASLI
        $dbRiwayat = Presensi::with(['statusCi', 'statusCo'])
                    ->where('id_user', $id_user)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get()
                    ->keyBy('tanggal');

        // 4. Ambil Kalender Libur
        $hariLibur = \App\Models\HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayat = collect();

        // 5. ON-THE-FLY GENERATION (Sihir Kalender)
        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            if ($dbRiwayat->has($dateString)) {
                $riwayat->push($dbRiwayat->get($dateString));
            } else {
                if ($date->lte($batasLoop)) {
                    $isLibur = $date->isSunday();
                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                            $isLibur = true; break;
                        }
                    }

                    $statusMock = new \App\Models\StatusPresensi(['name' => $isLibur ? 'Libur' : 'Alfa']);
                    $mock = new Presensi(['tanggal' => $dateString, 'jam_masuk' => null, 'jam_pulang' => null]);
                    $mock->setRelation('statusCi', $statusMock);
                    $mock->setRelation('statusCo', $statusMock);
                    $riwayat->push($mock);
                }
            }
        }

        // Urutkan data secara Ascending (Dari tanggal 1 ke 30) agar rapi di kertas
        $riwayat = $riwayat->sortBy('tanggal')->values();

        // 6. Ciptakan objek profil palsu agar sesuai dengan format View PDF kamu
        $profil = (object)[
            'nama_lengkap' => $nama_lengkap,
            'sekolah_asal' => $instansi
        ];

        // 7. Cetak PDF
        $pdf = Pdf::loadView('admin.riwayat-presensi.cetak', [
            'siswa' => $profil,
            'riwayat' => $riwayat,
            'periode' => Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') // Info Bulan untuk Kop
        ]);

        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan-Presensi-'.$nama_lengkap.'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $kategori = $request->kategori ?? 'siswa';

        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->startOfDay() : $endOfMonth;

        // Ambil Data Profil Berdasarkan Kategori
        if ($kategori == 'siswa') {
            $users = \App\Models\SiswaMagang::with('user')->get();
        } else {
            $users = \App\Models\Tendik::with(['user', 'unitKerja'])->get();
        }

        // Ambil Semua Presensi di bulan tersebut untuk user-user di atas
        $idUsers = $users->pluck('id_user')->toArray();
        $presensiAll = Presensi::with('statusCi')
                        ->whereIn('id_user', $idUsers)
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->get()
                        ->groupBy('id_user');

        // Ambil Hari Libur
        $hariLibur = \App\Models\HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        // Buat Array Tanggal 1 s.d Akhir Bulan
        $hariInMonth = [];
        for ($d = $startOfMonth->copy(); $d->lte($endOfMonth); $d->addDay()) {
            $hariInMonth[] = $d->copy();
        }

        $laporan = [];

        // ON-THE-FLY GENERATION UNTUK EXCEL
        foreach ($users as $u) {
            $presensiUser = $presensiAll->has($u->id_user) ? $presensiAll->get($u->id_user)->keyBy('tanggal') : collect();
            $tanggalBikinAkun = Carbon::parse($u->user->created_at)->startOfDay();

            $row = [
                'nama' => $u->nama_lengkap,
                'identitas' => $kategori == 'siswa' ? ($u->nis ?? '-') : ($u->nip ?? '-'),
                'instansi' => $kategori == 'siswa' ? ($u->sekolah_asal ?? '-') : ($u->unitKerja->nama_unit ?? '-'),
                'rekap' => [],
                'hadir' => 0, 'telat' => 0, 'alfa' => 0, 'libur' => 0
            ];

            foreach ($hariInMonth as $date) {
                $dateString = $date->format('Y-m-d');
                $simbol = '';

                if ($date->lt($tanggalBikinAkun)) {
                    $simbol = '-'; // Belum bikin akun
                } elseif ($presensiUser->has($dateString)) {
                    $p = $presensiUser->get($dateString);
                    if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') { $simbol = 'H'; $row['hadir']++; }
                    elseif ($p->statusCi && $p->statusCi->name == 'Terlambat') { $simbol = 'T'; $row['telat']++; }
                    elseif ($p->statusCi && $p->statusCi->name == 'Libur') { $simbol = 'L'; $row['libur']++; }
                    else { $simbol = 'A'; $row['alfa']++; }
                } else {
                    if ($date->lte($batasLoop)) {
                        $isLibur = $date->isSunday();
                        foreach ($hariLibur as $hl) {
                            if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                                $isLibur = true; break;
                            }
                        }
                        if ($isLibur) { $simbol = 'L'; $row['libur']++; }
                        else { $simbol = 'A'; $row['alfa']++; }
                    } else {
                        $simbol = ''; // Hari belum terlewati (kosong)
                    }
                }
                $row['rekap'][$dateString] = $simbol;
            }
            $laporan[] = $row;
        }

        // Return sebagai File Excel (xls)
        $namaKategori = ucfirst($kategori);
        $namaFile = "Rekap_Presensi_{$namaKategori}_{$bulan}_{$tahun}.xls";

        return response(view('admin.riwayat-presensi.excel', compact('laporan', 'hariInMonth', 'bulan', 'tahun', 'kategori')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="'.$namaFile.'"');
    }
}
