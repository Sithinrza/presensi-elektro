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

       // Waktu saat ini untuk batas loop (jangan hitung Alfa untuk hari esok)
        $waktuSekarang = Carbon::now('Asia/Makassar');
        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Ambil tanggal kapan user ini pertama kali dibuat di database
        $tanggalBikinAkun = Carbon::parse($user->created_at)->startOfDay();

        // Tentukan titik mulai: Pilih tanggal 1 awal bulan, ATAU tanggal bikin akun (pilih yang paling akhir/baru)
        $mulaiLoop = $startOfMonth->max($tanggalBikinAkun);

        $batasLoop = $endOfMonth->isFuture() ? $waktuSekarang->startOfDay() : $endOfMonth;
        // ------------------------------------

        // 1. Ambil Data Presensi ASLI dari database bulan ini
        $dbRiwayat = Presensi::with(['statusCi', 'statusCo', 'klaim'])
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
        $hadir = 0; $telat = 0; $alfa = 0; $libur = 0;

        // 3. ON-THE-FLY GENERATION: Looping setiap hari di bulan tersebut
        // Ubah variabel $startOfMonth menjadi $mulaiLoop
        for ($date = $mulaiLoop->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->format('Y-m-d');

            // Skenario A: User melakukan presensi di hari tersebut
            if ($dbRiwayat->has($dateString)) {
                $presensi = $dbRiwayat->get($dateString);
                $riwayatFinal->push($presensi);

                if ($presensi->id_status_ci == 1) $hadir++;
                elseif ($presensi->id_status_ci == 2) $telat++;
                elseif ($presensi->id_status_ci == 3) $alfa++;
                elseif ($presensi->id_status_ci == 6) $libur++;
            }
            // Skenario B: User KOSONG (Tidak ada data presensi)
            else {
                // Hanya proses jika tanggal tersebut bukan tanggal di masa depan
                if ($date->lte($batasLoop)) {

                    $isLibur = $date->isSunday(); // Deteksi otomatis Hari Minggu

                    // Deteksi tanggal merah dari tabel Admin
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

                    // Ciptakan data bayangan agar muncul di tabel
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

        // Urutkan dari tanggal terbaru ke terlama
        $riwayat = $riwayatFinal->sortByDesc('tanggal')->values();

        if ($role == 'tendik') {
            $layout = 'layouts.tendik';
        } elseif ($role == 'siswa' || $role == 'siswa magang') {
            $layout = 'layouts.siswa';
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('presensi.riwayat-presensi', compact('layout', 'riwayat', 'bulan', 'tahun', 'hadir', 'telat', 'alfa', 'libur'));
    }
}
