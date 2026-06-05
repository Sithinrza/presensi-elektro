<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenilaianMagang;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    // Menampilkan daftar siswa yang SUDAH dinilai pembimbing
    public function index()
    {
        // Hanya ambil data dari tabel penilaian, bawa relasi siswa-nya
        $penilaian = PenilaianMagang::with('siswa')->latest()->get();

        return view('admin.sertifikat.index', compact('penilaian'));
    }

    // Menyimpan nomor sertifikat dari form Admin
    public function updateNomor(Request $request, $id_penilaian)
    {
        $request->validate([
            'nomor_sertifikat' => 'required|string|max:255'
        ]);

        $nilai = PenilaianMagang::findOrFail($id_penilaian);

        $nilai->update([
            'nomor_sertifikat' => $request->nomor_sertifikat
        ]);

        return back()->with('success', 'Nomor Sertifikat resmi berhasil diterbitkan!');
    }

    public function cetakSertifikat($id_penilaian)
    {
        $nilai = PenilaianMagang::with(['siswa', 'siswa.presensi.statusCi'])->findOrFail($id_penilaian);
        $siswa = $nilai->siswa;

        if (empty($nilai->nomor_sertifikat)) {
            return redirect()->back()->with('error', 'Nomor Sertifikat belum diisi!');
        }

        $kajurAktif = \App\Models\Kajur::where('status_aktif', true)->first();
        if (!$kajurAktif) {
            return redirect()->back()->with('error', 'Data Kajur Aktif belum diatur!');
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
            'kajur_nama' => $kajurAktif->nama_lengkap,
            'kajur_nip' => $kajurAktif->nip,
            'nomor_sertifikat' => $nilai->nomor_sertifikat,
            'alpa' => $siswa->presensi ? $siswa->presensi->where('statusCi.name', 'Alfa')->count() : 0
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pembimbing.nilai.sertifikat', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('Sertifikat_' . $siswa->nama_lengkap . '.pdf');
    }
}
