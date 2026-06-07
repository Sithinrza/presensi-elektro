<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenilaianMagang;
use App\Models\Kajur; // Pastikan Model Kajur dipanggil
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatController extends Controller
{
    // Menampilkan daftar siswa yang SUDAH dinilai pembimbing
    public function index()
    {
        // Hanya ambil data dari tabel penilaian, bawa relasi siswa-nya
        $penilaian = PenilaianMagang::with('siswa')->latest()->get();

        return view('admin.sertifikat.index', compact('penilaian'));
    }

    // Menyimpan nomor sertifikat dari form Admin (SEKALIGUS MENGUNCI KAJUR)
    public function updateNomor(Request $request, $id_penilaian)
    {
        $request->validate([
            'nomor_sertifikat' => 'required|string|max:255'
        ]);

        // 1. Cek dulu apakah ada Kajur yang aktif
        $kajurAktif = Kajur::where('status_aktif', true)->first();
        if (!$kajurAktif) {
            return back()->with('error', 'Gagal menerbitkan sertifikat! Data Kajur Aktif belum diatur oleh sistem.');
        }

        $nilai = PenilaianMagang::findOrFail($id_penilaian);

        // 2. Simpan Nomor Sertifikat DAN Kunci ID Kajur saat ini
        $nilai->update([
            'nomor_sertifikat' => $request->nomor_sertifikat,
            'id_kajur'         => $kajurAktif->id_kajur // Mengunci sejarah Kajur
        ]);

        return back()->with('success', 'Nomor Sertifikat resmi diterbitkan dan Tanda Tangan Kajur telah dikunci!');
    }

    public function cetakSertifikat($id_penilaian)
    {
        // Tambahkan relasi 'kajur' di dalam with()
        $nilai = PenilaianMagang::with(['siswa', 'siswa.presensi.statusCi', 'kajur'])->findOrFail($id_penilaian);
        $siswa = $nilai->siswa;

        if (empty($nilai->nomor_sertifikat)) {
            return redirect()->back()->with('error', 'Nomor Sertifikat belum diisi oleh Admin!');
        }

        // AMBIL KAJUR DARI DATA PENILAIAN YANG SUDAH TERKUNCI
        $kajur = $nilai->kajur;

        // Fallback: Jika sertifikat lama (sebelum ada fitur id_kajur), cari yg aktif saat ini
        if (!$kajur) {
            $kajur = Kajur::where('status_aktif', true)->first();
            if (!$kajur) {
                return redirect()->back()->with('error', 'Data Kajur tidak ditemukan di sistem!');
            }
        }

        $huruf = 'D'; $keterangan = 'Belum Lulus';
        if ($nilai->rata_rata >= 8.50) { $huruf = 'A'; $keterangan = 'Lulus Istimewa'; }
        elseif ($nilai->rata_rata >= 7.50) { $huruf = 'B'; $keterangan = 'Lulus Baik Sekali'; }
        elseif ($nilai->rata_rata >= 6.00) { $huruf = 'C'; $keterangan = 'Lulus Baik'; }

        $data = [
            'siswa' => $siswa,
            'nilai' => $nilai,
            'rataRata' => $nilai->rata_rata,
            'huruf' => $huruf,
            'keterangan' => $keterangan,
            'kajur_nama' => $kajur->nama_lengkap, 
            'kajur_nip' => $kajur->nip,
            'nomor_sertifikat' => $nilai->nomor_sertifikat,
            'alpa' => $siswa->presensi ? $siswa->presensi->where('statusCi.name', 'Alfa')->count() : 0
        ];

        $pdf = Pdf::loadView('pembimbing.nilai.sertifikat', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('Sertifikat_' . $siswa->nama_lengkap . '.pdf');
    }
}
