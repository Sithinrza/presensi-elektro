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
        $totalHariKerja = 22;

        $siswa = SiswaMagang::with('user')->get()->map(function ($s) use ($totalHariKerja) {
            // Dihitung berdasarkan status CI = Tepat Waktu (ID 1)
            $totalHadir = Presensi::where('id_user', $s->id_user)
                                  ->where('id_status_ci', 1)
                                  ->whereMonth('tanggal', date('m'))
                                  ->count();

            $efektivitas = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100) : 0;
            $s->efektivitas = $efektivitas > 100 ? 100 : $efektivitas;
            return $s;
        });

        $tendik = Tendik::with(['user', 'unitKerja'])->get()->map(function ($t) use ($totalHariKerja) {
            $totalHadir = Presensi::where('id_user', $t->id_user)
                                  ->where('id_status_ci', 1)
                                  ->whereMonth('tanggal', date('m'))
                                  ->count();

            $efektivitas = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100) : 0;
            $t->efektivitas = $efektivitas > 100 ? 100 : $efektivitas;
            return $t;
        });

        return view('admin.riwayat-presensi.index', compact('siswa', 'tendik'));
    }

    public function showDetail($id_user)
    {
        // 1. Ambil data User beserta relasi profilnya
        $user = \App\Models\User::with(['siswaMagang', 'tendik'])->findOrFail($id_user);

        // 2. Tentukan Data Profil Berdasarkan Role (Siswa / Tendik)
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
            // Cek apakah relasi unitKerja ada sebelum memanggil namanya
            $instansi = $user->tendik->unitKerja ? $user->tendik->unitKerja->nama_unit : '-';
        }

        // 3. Ambil data Riwayat Presensi (Tambahkan relasi 'klaim')
        $riwayat = Presensi::with(['statusCi', 'statusCo', 'klaim'])
                    ->where('id_user', $id_user)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // 4. Hitung Statistik (Check In)
        $statistik = [
            'Tepat CI' => $riwayat->where('id_status_ci', 1)->count(), // 1 = Tepat Waktu
            'Telat CI' => $riwayat->where('id_status_ci', 2)->count(), // 2 = Terlambat
            'Alfa'     => $riwayat->where('id_status_ci', 3)->count(), // 3 = Alfa
            'Tepat CO' => $riwayat->whereIn('id_status_co', [1, 4])->count(), // 1=Tepat Wkt, 4=Check Out
            'Lupa CO'  => $riwayat->where('id_status_co', 5)->count(), // 5=Lupa Check-Out
        ];

        // 5. Kembalikan ke View dengan data yang sudah rapi
        return view('admin.riwayat-presensi.show', compact(
            'riwayat',
            'statistik',
            'nama_lengkap',
            'role',
            'instansi'
        ));
    }

    public function cetakPdf($id_user)
    {
        // 1. Ambil data profil anak
        $siswa = SiswaMagang::where('id_user', $id_user)->firstOrFail();

        // 2. Ambil data riwayat presensinya
        $riwayat = Presensi::with(['statusCi', 'statusCo'])
                    ->where('id_user', $id_user)
                    ->orderBy('tanggal', 'asc')
                    ->get();

        // 3. Ubah file tampilan HTML menjadi PDF
        $pdf = Pdf::loadView('admin.riwayat-presensi.cetak', compact('siswa', 'riwayat'));

        // 4. Atur ukuran kertas ke A4 (potrait)
        $pdf->setPaper('A4', 'portrait');

        // 5. Langsung tampilkan (stream) atau download PDF
        return $pdf->stream('Laporan-Presensi-'.$siswa->nama_lengkap.'.pdf');
    }
}
