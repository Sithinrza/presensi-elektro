<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembimbing;
use App\Models\SiswaMagang;
use App\Models\PenilaianMagang;
use App\Models\Kajur; // Tambahkan ini
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        $daftarSiswa = SiswaMagang::with('penilaian')
            ->where('id_pembimbing', $pembimbing->id_pembimbing)
            ->orderBy('tanggal_selesai', 'asc')
            ->get();

        $hariIni = Carbon::today();

        return view('pembimbing.nilai.index', compact('daftarSiswa', 'hariIni'));
    }

    public function create($id_siswa)
    {
        $siswa = SiswaMagang::with(['presensi.statusCi'])->findOrFail($id_siswa);

        if ($siswa->penilaian) {
            return redirect()->route('pembimbing.nilai.edit', $id_siswa);
        }

        // HANYA HITUNG ALFA
        $alpa = $siswa->presensi ? $siswa->presensi->where('statusCi.name', 'Alfa')->count() : 0;

        return view('pembimbing.nilai.form', compact('siswa', 'alpa'));
    }

    public function store(Request $request)
    {
        $fields = [
            'kecakapan_kerja', 'menerima_perintah', 'sikap_perilaku', 'inisiatif_kreatifitas',
            'disiplin_kehadiran', 'tanggung_jawab', 'pemahaman_teknis', 'persiapan_kerja',
            'kerjasama_team', 'mutu_hasil_kerja'
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $request->merge([$field => str_replace(',', '.', $request->$field)]);
            }
        }

        $request->validate([
            'id_siswa'              => 'required|exists:siswa_magang,id_siswa',
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

        $totalNilai = $request->kecakapan_kerja + $request->menerima_perintah +
                      $request->sikap_perilaku + $request->inisiatif_kreatifitas +
                      $request->disiplin_kehadiran + $request->tanggung_jawab +
                      $request->pemahaman_teknis + $request->persiapan_kerja +
                      $request->kerjasama_team + $request->mutu_hasil_kerja;

        $rataRata = round($totalNilai / 10, 2);

        PenilaianMagang::updateOrCreate(
            ['id_siswa' => $request->id_siswa],
            [
                'id_user'               => Auth::id(),
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
                'rata_rata'             => $rataRata
            ]
        );

        return redirect()->route('pembimbing.nilai.index')->with('success', 'Penilaian siswa berhasil disimpan!');
    }

    public function edit($id_siswa)
    {
        $siswa = SiswaMagang::with(['presensi.statusCi', 'penilaian'])->findOrFail($id_siswa);

        if (!$siswa->penilaian) {
            return redirect()->route('pembimbing.nilai.create', $id_siswa);
        }

        // HANYA HITUNG ALFA
        $alpa = $siswa->presensi ? $siswa->presensi->where('statusCi.name', 'Alfa')->count() : 0;

        return view('pembimbing.nilai.form', compact('siswa', 'alpa'));
    }

    public function update(Request $request, $id_siswa)
    {
        return $this->store($request);
    }

    public function cetakSertifikat($id_siswa)
    {
        // Panggil relasi kajur sekaligus untuk menghemat query database
        $siswa = SiswaMagang::with(['penilaian.kajur'])->findOrFail($id_siswa);
        $nilai = $siswa->penilaian;

        if (!$nilai) {
            return redirect()->back()->with('error', 'Siswa ini belum memiliki nilai!');
        }

        // VALIDASI 1: CEK NOMOR SERTIFIKAT DARI ADMIN
        if (empty($nilai->nomor_sertifikat)) {
            return redirect()->back()->with('error', 'Nomor Sertifikat belum diterbitkan oleh Admin!');
        }

        // VALIDASI 2: AMBIL KAJUR YANG TERKUNCI DARI TABEL PENILAIAN
        $kajur = $nilai->kajur;

        // Fallback: Jika id_kajur di penilaian kosong (misal data lama), ambil kajur aktif saat ini
        if (!$kajur) {
            $kajur = Kajur::where('status_aktif', true)->first();
            if (!$kajur) {
                return redirect()->back()->with('error', 'Data Kajur tidak ditemukan di sistem!');
            }
        }

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
            'kajur_nama' => $kajur->nama_lengkap,
            'kajur_nip' => $kajur->nip,           
            'nomor_sertifikat' => $nilai->nomor_sertifikat
        ];

        $pdf = Pdf::loadView('pembimbing.nilai.sertifikat', $data)->setPaper('A4', 'landscape');

        return $pdf->stream('Sertifikat_Magang_' . $siswa->nama_lengkap . '.pdf');
    }
}
