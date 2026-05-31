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

        // Ambil siswa dengan relasi presensi
        $query = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing)
                            ->with(['presensi.statusCi', 'presensi.statusCo']);

        // Filter pencarian nama siswa
        if ($request->has('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        $anakBimbingan = $query->get();

        // Menghitung statistik agar siap tampil di view index (kartu-kartu siswa)
        foreach ($anakBimbingan as $s) {
            $s->stat_hadir = $s->presensi->where('statusCi.name', 'Tepat Waktu')->count();
            $s->stat_telat = $s->presensi->where('statusCi.name', 'Terlambat')->count();
            $s->stat_alfa  = $s->presensi->where('statusCi.name', 'Alfa')->count();
            $s->stat_tepat_co = $s->presensi->where('statusCo.name', 'Tepat Waktu')->count();
            $s->stat_lupa_co  = $s->presensi->where('statusCo.name', 'Lupa Check-Out')->count();
        }

        return view('pembimbing.presensi-siswa.index', compact('anakBimbingan'));
    }

    public function show(Request $request, $id_user)
    {
        $siswa = SiswaMagang::where('id_user', $id_user)->firstOrFail();

        // Ambil filter bulan dan tahun, default bulan/tahun saat ini
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Mulai looping dari tanggal dia bikin akun (agar tidak ada Alfa palsu di bulan pertama dia masuk)
        $tanggalBikinAkun = Carbon::parse($siswa->created_at)->startOfDay();
        $mulaiLoop = $startOfMonth->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->startOfDay() : $endOfMonth;

        // 1. Ambil Data Presensi ASLI dari database bulan ini
        $dbRiwayat = Presensi::with(['statusCi', 'statusCo'])
                             ->where('id_user', $id_user)
                             ->whereMonth('tanggal', $bulan)
                             ->whereYear('tanggal', $tahun)
                             ->get()
                             ->keyBy('tanggal');

        // 2. Ambil kalender Hari Libur dari Admin
        $hariLibur = HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayatPresensi = collect();

        // Siapkan array statistik untuk halaman detail
        $statistik = [
            'Tepat CI' => 0, 'Telat CI' => 0, 'Alfa' => 0,
            'Tepat CO' => 0, 'Lupa CO' => 0, 'Libur' => 0
        ];

        // 3. ON-THE-FLY GENERATION: Looping kalender
        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            if ($dbRiwayat->has($dateString)) {
                $p = $dbRiwayat->get($dateString);
                $riwayatPresensi->push($p);

                // Hitung Statistik jika data ada di DB
                if ($p->statusCi && $p->statusCi->name == 'Tepat Waktu') $statistik['Tepat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Terlambat') $statistik['Telat CI']++;
                if ($p->statusCi && $p->statusCi->name == 'Alfa') $statistik['Alfa']++;
                if ($p->statusCi && $p->statusCi->name == 'Libur') $statistik['Libur']++;

                if ($p->statusCo && $p->statusCo->name == 'Tepat Waktu') $statistik['Tepat CO']++;
                if ($p->statusCo && $p->statusCo->name == 'Lupa Check-Out') $statistik['Lupa CO']++;
            } else {
                // Proses hari yang kosong (hanya sampai batas hari ini)
                if ($date->lte($batasLoop)) {
                    $isLibur = $date->isSunday();

                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                            $isLibur = true; break;
                        }
                    }

                    if ($isLibur) {
                        $statistik['Libur']++;
                        $statusMock = new StatusPresensi(['name' => 'Libur']);
                    } else {
                        $statistik['Alfa']++;
                        $statusMock = new StatusPresensi(['name' => 'Alfa']);
                    }

                    // Buat data presensi bayangan untuk dikirim ke view
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

        // Urutkan dari yang terbaru ke terlama
        $riwayatPresensi = $riwayatPresensi->sortByDesc('tanggal')->values();

        return view('pembimbing.presensi-siswa.show', compact('siswa', 'riwayatPresensi', 'statistik', 'bulan', 'tahun'));
    }
}
