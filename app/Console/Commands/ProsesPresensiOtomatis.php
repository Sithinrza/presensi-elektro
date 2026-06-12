<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use App\Models\HariLibur;
use Carbon\Carbon;

class ProsesPresensiOtomatis extends Command
{
    protected $signature = 'presensi:otomatis';
    protected $description = 'Sapu bersih Alpa, Lupa CO, dan set otomatis Libur tepat sebelum ganti hari';



    public function handle()
    {
        //Carbon::setTestNow(Carbon::create(2026, 6, 8, 23, 59, 0, 'Asia/Makassar'));

        $waktuSekarang = Carbon::now('Asia/Makassar');
        $tanggalHariIni = $waktuSekarang->format('Y-m-d');
        $hariIniIso = $waktuSekarang->dayOfWeekIso;

        // Ambil ID Status dari Database
        $statusAlpa = StatusPresensi::where('name', 'Alpa')->first();
        $statusLupaCO = StatusPresensi::where('name', 'Lupa Check-Out')->first();
        $statusLibur = StatusPresensi::where('name', 'Libur')->first();

        if (!$statusAlpa || !$statusLupaCO || !$statusLibur) {
            $this->error("Pastikan status 'Alpa', 'Lupa Check-Out', dan 'Libur' sudah ada di tabel status_presensi!");
            return;
        }

        // Ambil semua id_user dari anak magang dan tendik
        $idSiswa = SiswaMagang::pluck('id_user')->toArray();
        $idTendik = Tendik::pluck('id_user')->toArray();
        $semuaIdTarget = array_merge($idSiswa, $idTendik);

        // =========================================================
        // 1. CEK JIKA HARI INI LIBUR ATAU AKHIR PEKAN
        // =========================================================
        $hariLiburIni = HariLibur::where('tanggal_mulai', '<=', $tanggalHariIni)
                                 ->where('tanggal_selesai', '>=', $tanggalHariIni)
                                 ->first();
        $isWeekend = in_array($hariIniIso, [6, 7]);

        if ($hariLiburIni || $isWeekend) {
            $jumlahLibur = 0;

            foreach ($semuaIdTarget as $idUser) {
                if (!$idUser) continue;

                $presensiHariIni = Presensi::where('id_user', $idUser)
                                           ->where('tanggal', $tanggalHariIni)
                                           ->first();

                // Jika belum ada data sama sekali, buatkan record Libur
                if (!$presensiHariIni) {
                    Presensi::create([
                        'id_user'      => $idUser,
                        'id_status_ci' => $statusLibur->id_status_presensi,
                        'id_status_co' => $statusLibur->id_status_presensi,
                        'tanggal'      => $tanggalHariIni,
                        'jam_masuk'    => null,
                        'jam_pulang'   => null,
                    ]);
                    $jumlahLibur++;
                }
            }

            $keterangan = $hariLiburIni ? "Libur Nasional ({$hariLiburIni->nama_libur})" : "Akhir Pekan";
            $this->info("Hari ini $keterangan. $jumlahLibur orang otomatis dicatat Libur.");

            // Hentikan proses, tidak perlu lanjut ke pencarian Alfa/Lupa CO
            return;
        }

        // =========================================================
        // 2. JIKA HARI KERJA NORMAL (PROSES ALFA & LUPA CO)
        // =========================================================
        $jumlahAlpa = 0;
        $jumlahLupaCo = 0;

        foreach ($semuaIdTarget as $idUser) {
            if (!$idUser) continue;

            $presensiHariIni = Presensi::with('statusCi')
                                       ->where('id_user', $idUser)
                                       ->where('tanggal', $tanggalHariIni)
                                       ->first();

            // KONDISI A: TIDAK MUNCUL SAMA SEKALI
            if (!$presensiHariIni) {
                $waktuSekarang = Carbon::now('Asia/Makassar');
                $batasAlpa = Carbon::createFromTime(8, 30, 0, 'Asia/Makassar');

                // HANYA EKSEKUSI ALFA JIKA SUDAH LEWAT JAM 08:30 PAGI
                if ($waktuSekarang->greaterThan($batasAlpa)) {
                    Presensi::create([
                        'id_user'      => $idUser,
                        'id_status_ci' => $statusAlpa->id_status_presensi,
                        'id_status_co' => $statusAlpa->id_status_presensi,
                        'tanggal'      => $tanggalHariIni,
                        'jam_masuk'    => null,
                        'jam_pulang'   => null,
                    ]);
                    $jumlahAlpa++;
                }
            }
            // KONDISI B: SUDAH MASUK TAPI BELUM PULANG SAMPAI 23:59
            else if ($presensiHariIni->jam_pulang == null) {

                if ($presensiHariIni->statusCi && in_array($presensiHariIni->statusCi->name, ['Tepat Waktu', 'Terlambat'])) {
                    $presensiHariIni->update([
                        'id_status_co' => $statusLupaCO->id_status_presensi,
                    ]);
                    $jumlahLupaCo++;
                }
                else if ($presensiHariIni->statusCi && $presensiHariIni->statusCi->name == 'Alpa') {
                    $presensiHariIni->update([
                        'id_status_co' => $statusAlpa->id_status_presensi,
                    ]);
                }
            }
        }

        $this->info("Rekap Hari Ini: $jumlahAlpa orang bolos (Alpa), $jumlahLupaCo orang Lupa CO.");
    }
}
