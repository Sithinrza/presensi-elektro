<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenilaianMagang;
use App\Models\Kajur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatController extends Controller
{
    // Menampilkan daftar siswa yang SUDAH dinilai pembimbing
    public function index()
    {
        $penilaian = PenilaianMagang::with('siswa')->latest()->get();
        return view('admin.sertifikat.index', compact('penilaian'));
    }

    // Menyimpan nomor sertifikat dari form Admin (SEKALIGUS MENGUNCI KAJUR)
    public function updateNomor(Request $request, $id_penilaian)
    {
        // 1. Menggunakan Validator manual agar tidak nyasar ke route GET jika terjadi error (misal kepanjangan)
        $validator = Validator::make($request->all(), [
            'nomor_sertifikat' => 'required|string|max:100' // Pastikan max diset ke 50 atau 100 sesuai database barumu
        ]);

        if ($validator->fails()) {
            // PERBAIKAN: Gunakan redirect()->route(...) secara eksplisit, BUKAN back()
            return redirect()->route('admin.sertifikat.index')->with('error', 'Gagal menyimpan! Format nomor sertifikat tidak valid atau terlalu panjang.');
        }

        // 2. Cek dulu apakah ada Kajur yang aktif
        $kajurAktif = Kajur::where('status_aktif', true)->first();
        if (!$kajurAktif) {
            return redirect()->route('admin.sertifikat.index')->with('error', 'Gagal menerbitkan sertifikat! Data Kajur Aktif belum diatur oleh sistem.');
        }

        $nilai = PenilaianMagang::findOrFail($id_penilaian);

        // 3. Simpan Nomor Sertifikat DAN Kunci ID Kajur saat ini
        $nilai->update([
            'nomor_sertifikat' => $request->nomor_sertifikat,
            'id_kajur'         => $kajurAktif->id_kajur // Mengunci sejarah Kajur
        ]);

        return redirect()->route('admin.sertifikat.index')->with('success', 'Nomor Sertifikat resmi diterbitkan');
    }

    public function cetakSertifikat($id_penilaian)
    {
        $nilai = PenilaianMagang::with(['siswa', 'siswa.presensi.statusCi', 'kajur'])->findOrFail($id_penilaian);
        $siswa = $nilai->siswa;

        if (empty($nilai->nomor_sertifikat)) {
            return redirect()->route('admin.sertifikat.index')->with('error', 'Nomor Sertifikat belum diisi oleh Admin!');
        }

        // AMBIL KAJUR DARI DATA PENILAIAN YANG SUDAH TERKUNCI
        $kajur = $nilai->kajur;

        // Fallback: Jika sertifikat lama (sebelum ada fitur id_kajur), cari yg aktif saat ini
        if (!$kajur) {
            $kajur = Kajur::where('status_aktif', true)->first();
            if (!$kajur) {
                return redirect()->route('admin.sertifikat.index')->with('error', 'Data Kajur tidak ditemukan di sistem!');
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
            'alpa' => $siswa->presensi ? $siswa->presensi->where('statusCi.name', 'Alpa')->count() : 0
        ];

        $pdf = Pdf::loadView('pembimbing.nilai.sertifikat', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('Sertifikat_' . $siswa->nama_lengkap . '.pdf');
    }
}
