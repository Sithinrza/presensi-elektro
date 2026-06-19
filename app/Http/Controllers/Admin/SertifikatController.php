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

        // ===============================================================
        // LOGIKA AUTO-INCREMENT NOMOR SERTIFIKAT
        // ===============================================================
        $semuaSertifikat = PenilaianMagang::whereNotNull('nomor_sertifikat')->get();
        $maxUrut = 0;

        foreach ($semuaSertifikat as $p) {
            // Pecah string "001/DST/PL18..." berdasarkan garis miring '/'
            $parts = explode('/', $p->nomor_sertifikat);

            // Ambil bagian pertama (index 0) dan pastikan itu angka
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urut = (int)$parts[0];
                if ($urut > $maxUrut) {
                    $maxUrut = $urut;
                }
            }
        }

        // Tambah 1 dari nilai terbesar, lalu format jadi 3 digit (contoh: 002)
        $nextUrut = str_pad($maxUrut + 1, 3, '0', STR_PAD_LEFT);
        // ===============================================================

        return view('admin.sertifikat.index', compact('penilaian', 'nextUrut'));
    }

    // Menyimpan nomor sertifikat dari form Admin (SEKALIGUS MENGUNCI KAJUR)
    public function updateNomor(Request $request, $id_penilaian)
    {

        $validator = Validator::make($request->all(), [
            'prefix' => 'required|string',
            'middle' => 'required|string',
            'tahun'  => 'required|numeric'
        ], [
            'middle.required' => 'Bagian format surat (tengah) tidak boleh kosong!',
            'tahun.numeric'   => 'Kolom Tahun hanya boleh berisi angka!'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sertifikat.index')->with('error', $validator->errors()->first());
        }

        // 2. Cek dulu apakah ada Kajur yang aktif
        $kajurAktif = Kajur::where('status_aktif', true)->first();
        if (!$kajurAktif) {
            return redirect()->route('admin.sertifikat.index')->with('error', 'Gagal menerbitkan sertifikat! Data Kajur Aktif belum diatur oleh sistem.');
        }

        $nilai = PenilaianMagang::findOrFail($id_penilaian);

        $nomorSertifikatLengkap = $request->prefix . $request->middle . $request->tahun;

        // 4. Simpan Nomor Sertifikat DAN Kunci ID Kajur saat ini
        $nilai->update([
            'nomor_sertifikat' => $nomorSertifikatLengkap,
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
