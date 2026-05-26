<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KlaimPresensi;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class KlaimController extends Controller
{
    // Menampilkan daftar klaim yang masih 'pending'
    public function index()
    {
        $klaimPending = KlaimPresensi::with(['presensi.user.roles', 'presensi.statusCo'])
                                     ->where('status_verifikasi', 'pending')
                                     ->orderBy('created_at', 'asc')
                                     ->get();

        $klaimSelesai = KlaimPresensi::with(['presensi.user', 'verifikator'])
                                     ->whereIn('status_verifikasi', ['disetujui', 'ditolak'])
                                     ->orderBy('updated_at', 'desc')
                                     ->limit(50) // Biar ngga berat, ambil 50 terakhir
                                     ->get();

        return view('admin.klaim.index', compact('klaimPending', 'klaimSelesai'));
    }

    // Proses aksi Terima / Tolak
    public function verifikasi(Request $request, $id_klaim)
    {
        $request->validate([
            'aksi' => 'required|in:terima,tolak'
        ]);

        $klaim = KlaimPresensi::findOrFail($id_klaim);

        if ($request->aksi == 'terima') {
            $klaim->update([
                'status_verifikasi' => 'disetujui',
                'diverifikasi_oleh' => Auth::user()->id_user
            ]);

            // Ubah status CO di tabel presensi dari 'Lupa Check-Out' menjadi 'Tepat Waktu' (ID 1)
            Presensi::where('id_presensi', $klaim->id_presensi)->update([
                'id_status_co' => 1
            ]);

            $pesan = 'Klaim berhasil disetujui. Status presensi telah diubah menjadi Tepat Waktu CO.';
        } else {
            $klaim->update([
                'status_verifikasi' => 'ditolak',
                'diverifikasi_oleh' => Auth::user()->id_user
            ]);
            $pesan = 'Klaim ditolak. Status presensi tetap Lupa Check-Out.';
        }

        return redirect()->back()->with('success', $pesan);
    }
}
