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
        $userId = Auth::id();
        $pembimbing = Pembimbing::where('id_user', $userId)->first();

        if (!$pembimbing) {
            return redirect()->back()->with('error', 'Profil pembimbing Anda belum terdaftar!');
        }

        $query = SiswaMagang::where('id_pembimbing', $pembimbing->id_pembimbing);

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        // 👈 TAMBAHAN: Logika Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 👈 TAMBAHAN: Pengurutan Aktif ke atas
        $query->orderBy('status', 'asc')->orderBy('nama_lengkap', 'asc');

        $anakBimbingan = $query->withCount([
            'logbook',
            'logbook as belum_divalidasi' => function($query) {
                $query->where('status', 'pending');
            }
        ])->get();

        foreach ($anakBimbingan as $s) {
            $s->log_terakhir = \App\Models\Log::where('id_user', $s->id_user)
                                              ->orderBy('report_date', 'desc')
                                              ->first();
        }

        return view('pembimbing.monitoring.index', compact('anakBimbingan'));
    }

    public function show($id)
    {
        $siswa = SiswaMagang::where('id_siswa', $id)->firstOrFail();

        $riwayatLog = \App\Models\Log::where('id_user', $siswa->id_user)
                                     ->orderBy('report_date', 'desc')
                                     ->get();

        $belum_divalidasi = $riwayatLog->where('status', 'pending')->count();

        return view('pembimbing.monitoring.show', compact('siswa', 'riwayatLog', 'belum_divalidasi'));
    }

    public function validasi(Request $request, $id_log)
    {
        $request->validate([
            'status'             => 'required|in:diterima,ditolak',
            'catatan_pembimbing' => 'nullable|string'
        ]);

        $log = \App\Models\Log::findOrFail($id_log);

        $log->update([
            'status'             => $request->status,
            'catatan_pembimbing' => $request->catatan_pembimbing
        ]);

        $pesan = $request->status == 'diterima'
            ? 'Logbook harian berhasil diterima dan diverifikasi!'
            : 'Logbook harian telah ditolak untuk direvisi siswa.';

        return redirect()->back()->with('success', $pesan);
    }
}
