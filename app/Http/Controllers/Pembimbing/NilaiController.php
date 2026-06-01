<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\SiswaMagang;
use App\Models\PenilaianMagang; // Wajib dipanggil untuk simpan nilai
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Wajib dipanggil untuk cetak PDF

class NilaiController extends Controller
{
    // Fungsi bawaanmu: Menampilkan halaman utama penilaian
    public function index()
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        // Ambil daftar siswa bimbingannya
        $daftarSiswa = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing)
            ->orderBy('tanggal_selesai', 'asc') // Urutkan dari yang paling cepat selesai magang
            ->get();

        $hariIni = Carbon::today();

        return view('pembimbing.nilai.index', compact('daftarSiswa', 'hariIni'));
    }

    public function create($id_siswa)
    {
        $siswa = SiswaMagang::with('presensi')->findOrFail($id_siswa);
        if ($siswa->penilaian) {
            return redirect()->route('pembimbing.nilai.edit', $id_siswa);
        }
        $sakit = $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 7)->count() : 0;
        $izin  = $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 8)->count() : 0;
        $alpa  = $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 3)->count() : 0;
        return view('pembimbing.nilai.form', compact('siswa', 'sakit', 'izin', 'alpa'));
    }

    // Fungsi Baru: Menyimpan nilai ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_siswa' => 'required|exists:siswa_magang,id_siswa',
            'kecakapan_kerja' => 'required|numeric|min:0|max:10',
            'menerima_perintah' => 'required|numeric|min:0|max:10',
            'sikap_perilaku' => 'required|numeric|min:0|max:10',
            'inisiatif_kreatifitas' => 'required|numeric|min:0|max:10',
            'disiplin_kehadiran' => 'required|numeric|min:0|max:10',
            'tanggung_jawab' => 'required|numeric|min:0|max:10',
            'pemahaman_teknis' => 'required|numeric|min:0|max:10',
            'persiapan_kerja' => 'required|numeric|min:0|max:10',
            'kerjasama_team' => 'required|numeric|min:0|max:10',
            'mutu_hasil_kerja' => 'required|numeric|min:0|max:10',
        ]);

        // Hitung Rata-rata
        $totalNilai = $request->kecakapan_kerja + $request->menerima_perintah +
                      $request->sikap_perilaku + $request->inisiatif_kreatifitas +
                      $request->disiplin_kehadiran + $request->tanggung_jawab +
                      $request->pemahaman_teknis + $request->persiapan_kerja +
                      $request->kerjasama_team + $request->mutu_hasil_kerja;

        $rataRata = round($totalNilai / 10, 2);

        // Simpan ke database (updateOrCreate agar tidak dobel jika diedit ulang)
        PenilaianMagang::updateOrCreate(
            ['id_siswa' => $request->id_siswa],
            [
                'id_user' => Auth::id(), // Menyimpan ID akun yang memberi nilai
                'kecakapan_kerja' => $request->kecakapan_kerja,
                'menerima_perintah' => $request->menerima_perintah,
                'sikap_perilaku' => $request->sikap_perilaku,
                'inisiatif_kreatifitas' => $request->inisiatif_kreatifitas,
                'disiplin_kehadiran' => $request->disiplin_kehadiran,
                'tanggung_jawab' => $request->tanggung_jawab,
                'pemahaman_teknis' => $request->pemahaman_teknis,
                'persiapan_kerja' => $request->persiapan_kerja,
                'kerjasama_team' => $request->kerjasama_team,
                'mutu_hasil_kerja' => $request->mutu_hasil_kerja,
                'rata_rata' => $rataRata
            ]
        );

        // Langsung arahkan ke rute cetak PDF setelah sukses menyimpan
        return redirect()->route('pembimbing.nilai.cetak', $request->id_siswa);
    }

    public function edit($id_siswa)
    {
        // Ambil data siswa lengkap dengan data nilai lamanya
        $siswa = SiswaMagang::with(['presensi', 'penilaian'])->findOrFail($id_siswa);
        if (!$siswa->penilaian) {
            return redirect()->route('pembimbing.nilai.create', $id_siswa);
        }
        $sakit = $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 7)->count() : 0;
        $izin  = $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 8)->count() : 0;
        $alpa  = $siswa->presensi ? $siswa->presensi->where('id_status_presensi', 3)->count() : 0;
        return view('pembimbing.nilai.form', compact('siswa', 'sakit', 'izin', 'alpa'));
    }

    public function update(Request $request, $id_siswa)
    {
        $request->validate([
            'kecakapan_kerja'       => 'required|numeric|min:0|max:10',
            'menerima_perintah'     => 'required|numeric|min:0|max:10',
            'sikap_perilaku'        => 'required|numeric|min:0|max:10',
            'inisiatif_kreatifitas' => 'required|numeric|min:0|max:10',
            'disiplin_kehadiran'    => 'required|numeric|min:0|max:10',
            'tanggung_jawab'        => 'required|numeric|min:0|max:10',
            'pemahaman_teknis'      => 'required|numeric|min:0|max:10',
            'persiapan_kerja'       => 'required|numeric|min:0|max:10',
            'kerjasama_team'        => 'required|numeric|min:0|max:10',
            'mutu_hasil_kerja'      => 'required|numeric|min:0|max:10',
        ]);

        $nilai = PenilaianMagang::where('id_siswa', $id_siswa)->firstOrFail();

        $totalNilai = $request->kecakapan_kerja + $request->menerima_perintah +
                      $request->sikap_perilaku + $request->inisiatif_kreatifitas +
                      $request->disiplin_kehadiran + $request->tanggung_jawab +
                      $request->pemahaman_teknis + $request->persiapan_kerja +
                      $request->kerjasama_team + $request->mutu_hasil_kerja;
        $rataRata = round($totalNilai / 10, 2);
        $nilai->update([
            'kecakapan_kerja'       => $request->kecakapan_kerja,
            'menerima_perintah'     => $request->menerima_perintah,
            'sikap_perilaku'        => $request->sikap_perilaku,
            'inisiatif_kreatifitas' => $request->inisiatif_kreatifitas,
            'disiplin_kehadiran'    => $request->disiplin_kehadiran,
            'tanggung_jawab'        => $request->tanggung_jawab,
            'pemahaman_teknis'      => $request->pemahaman_teknis,
            'persiapan_kerja'       => $request->persiapan_kerja,
            'kerjasama_team'        => $request->kerjasama_team,
            'mutu_hasil_kerja'      => $request->mutu_hasil_kerja,
            'rata_rata'            => $rataRata
        ]);
        return redirect()->route('pembimbing.nilai.index')->with('success', 'Pembaruan nilai berhasil diperbarui!');
    }

    // Fungsi Baru: Merilis PDF Sertifikat
    public function cetakSertifikat($id_siswa)
    {
        $siswa = SiswaMagang::with('penilaian')->findOrFail($id_siswa);
        $nilai = $siswa->penilaian;

        if (!$nilai) {
            return redirect()->back()->with('error', 'Siswa ini belum memiliki nilai!');
        }

        // Tentukan Grade berdasarkan skala 10
        $huruf = 'D';
        $keterangan = 'Belum Lulus';

        if ($nilai->rata_rata >= 8.50) {
            $huruf = 'A';
            $keterangan = 'Lulus Istimewa';
        } elseif ($nilai->rata_rata >= 7.50) {
            $huruf = 'B';
            $keterangan = 'Lulus Baik Sekali';
        } elseif ($nilai->rata_rata >= 6.00) {
            $huruf = 'C';
            $keterangan = 'Lulus Baik';
        }

        $data = [
            'siswa' => $siswa,
            'nilai' => $nilai,
            'rataRata' => $nilai->rata_rata,
            'huruf' => $huruf,
            'keterangan' => $keterangan,
            'kajur_nama' => 'M. HELMY NOOR, S.ST., M.T.',
            'kajur_nip' => '19750507 200012 1 001'
        ];

        // Format PDF Landscape (Membutuhkan file view 'pembimbing.sertifikat-pdf')
        $pdf = Pdf::loadView('pembimbing.nilai.sertifikat', $data)->setPaper('A4', 'landscape');

        return $pdf->stream('Sertifikat_Magang_' . $siswa->nama_lengkap . '.pdf');
    }
}
