<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaMagang;
use App\Models\Pembimbing;
use Illuminate\Support\Facades\Auth;

class ReportMonitoringController extends Controller
{
    public function index(Request $request)
{
    // 1. Ambil ID User pembimbing yang sedang login
    $userId = Auth::id();

    // 2. Cari detail data pembimbing untuk mendapatkan id_pembimbing-nya
    $pembimbing = Pembimbing::where('id_user', $userId)->first();

    if (!$pembimbing) {
        return redirect()->back()->with('error', 'Profil pembimbing Anda belum terdaftar!');
    }

    // 3. Mulai query SiswaMagang, TAPI kunci hanya yang id_pembimbing-nya sesuai
    $query = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing);

    // 4. Fitur pencarian nama siswa jika pembimbing mengetik di input search
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
    }

    // 5. Hitung total logbook menggunakan relasi yang baru kita buat tadi
    $anakBimbingan = $query->withCount([
        'logbook', // ini akan menghasilkan kolom 'logbook_count' otomatis di blade
        'logbook as belum_divalidasi' => function($query) {
            $query->where('status', 'pending');
        }
    ])->get();

    // 6. Ambil data logbook terakhir untuk masing-masing anak bimbingan
    foreach ($anakBimbingan as $s) {
        $s->log_terakhir = \App\Models\Log::where('id_user', $s->id_user)
                                          ->orderBy('report_date', 'desc')
                                          ->first();
    }

    return view('pembimbing.monitoring.index', compact('anakBimbingan'));
}



public function show($id)
{
    // 1. Ambil data siswa berdasarkan id_siswa asli database kamu
    $siswa = SiswaMagang::where('id_siswa', $id)->firstOrFail();

    // 2. Ambil riwayat logbook milik siswa ini berdasarkan id_user-nya
    $riwayatLog = \App\Models\Log::where('id_user', $siswa->id_user)
                                 ->orderBy('report_date', 'desc')
                                 ->get();

    // 3. Hitung berapa logbook yang statusnya masih 'pending' (belum divalidasi)
    $belum_divalidasi = $riwayatLog->where('status', 'pending')->count();

    // 4. Kirim semua variabel ke halaman view detail pembimbing
    return view('pembimbing.monitoring.show', compact('siswa', 'riwayatLog', 'belum_divalidasi'));
}

public function validasi(Request $request, $id_log)
{
    // 1. Validasi inputan dari form pembimbing
    $request->validate([
        'status'             => 'required|in:diterima,ditolak',
        'catatan_pembimbing' => 'nullable|string'
    ]);

    // 2. Cari data logbook yang mau divalidasi
    $log = \App\Models\Log::findOrFail($id_log);

    // 3. Update status dan catatannya ke database
    $log->update([
        'status'             => $request->status,
        'catatan_pembimbing' => $request->catatan_pembimbing
    ]);

    // 4. Bikin pesan sukses dinamis berdasarkan tombol yang diklik bapaknya
    $pesan = $request->status == 'diterima'
        ? 'Logbook harian berhasil diterima dan diverifikasi!'
        : 'Logbook harian telah ditolak untuk direvisi siswa.';

    // 5. Kembalikan ke halaman sebelumnya dengan aman bawa status sukses
    return redirect()->back()->with('success', $pesan);
}

}
