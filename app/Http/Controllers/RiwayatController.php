<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\HariLibur;
use App\Models\StatusPresensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = strtolower($user->roles->first()->name);

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $tanggalBikinAkun = Carbon::parse($user->created_at)->startOfDay();
        $mulaiLoop = $startOfMonth->max($tanggalBikinAkun);
        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->startOfDay() : $endOfMonth;

        // 1. Ambil Data Presensi ASLI dari database bulan ini
        $dbRiwayat = Presensi::with(['statusCi', 'statusCo'])
                           ->where('id_user', $user->id_user)
                           ->whereMonth('tanggal', $bulan)
                           ->whereYear('tanggal', $tahun)
                           ->get()
                           ->keyBy('tanggal');

        // 2. Ambil kalender Hari Libur dari Admin
        $hariLibur = HariLibur::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();

        $riwayatFinal = collect();

        // DEKLARASI 7 VARIABEL STATISTIK
        $hadir = 0; $telat = 0; $alfa = 0; $libur = 0;
        $tepat_co = 0; $telat_co = 0; $lupa_co = 0;

        // 3. ON-THE-FLY GENERATION
        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            // Skenario A: User melakukan presensi
            if ($dbRiwayat->has($dateString)) {
                $presensi = $dbRiwayat->get($dateString);

                // LOGIKA LUPA CO OTOMATIS: Jika hari sudah lewat dan jam pulang kosong
                if ($dateString != $waktuSekarang->format('Y-m-d') && is_null($presensi->jam_pulang)) {
                    $statusLupa = new StatusPresensi(['name' => 'Lupa Check-Out']);
                    $presensi->setRelation('statusCo', $statusLupa);
                }

                $riwayatFinal->push($presensi);

                // Hitung statistik Check-In
                if ($presensi->statusCi && $presensi->statusCi->name == 'Tepat Waktu') $hadir++;
                elseif ($presensi->statusCi && $presensi->statusCi->name == 'Terlambat') $telat++;
                elseif ($presensi->statusCi && $presensi->statusCi->name == 'Alfa') $alfa++;
                elseif ($presensi->statusCi && $presensi->statusCi->name == 'Libur') $libur++;

                // Hitung statistik Check-Out
                if ($presensi->statusCo && in_array($presensi->statusCo->name, ['Tepat Waktu', 'Check Out'])) $tepat_co++;
                elseif ($presensi->statusCo && $presensi->statusCo->name == 'Terlambat CO') $telat_co++;
                elseif ($presensi->statusCo && $presensi->statusCo->name == 'Lupa Check-Out') $lupa_co++;
            }
            // Skenario B: User KOSONG (Tidak ada data)
            else {
                if ($date->lte($batasLoop)) {
                    $isLibur = $date->isSunday();

                    foreach ($hariLibur as $hl) {
                        if ($date->between(Carbon::parse($hl->tanggal_mulai), Carbon::parse($hl->tanggal_selesai))) {
                            $isLibur = true; break;
                        }
                    }

                    if ($isLibur) {
                        $libur++;
                        $statusMock = new StatusPresensi(['name' => 'Libur']);
                    } else {
                        $alfa++;
                        $statusMock = new StatusPresensi(['name' => 'Alfa']);
                    }

                    $mockPresensi = new Presensi([
                        'tanggal' => $dateString,
                        'jam_masuk' => null,
                        'jam_pulang' => null,
                    ]);
                    $mockPresensi->setRelation('statusCi', $statusMock);
                    $mockPresensi->setRelation('statusCo', $statusMock);

                    $riwayatFinal->push($mockPresensi);
                }
            }
        }

        $riwayat = $riwayatFinal->sortByDesc('tanggal')->values();

        if ($role == 'tendik') {
            $layout = 'layouts.tendik';
        } elseif ($role == 'siswa' || $role == 'siswa magang') {
            $layout = 'layouts.siswa';
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('presensi.riwayat-presensi', compact('layout', 'riwayat', 'bulan', 'tahun', 'hadir', 'telat', 'alfa', 'libur', 'tepat_co', 'telat_co', 'lupa_co'));
    }
}
