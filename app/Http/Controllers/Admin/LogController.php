<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\SiswaMagang;
use App\Models\Pembimbing;
use App\Models\User;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::query();

        // 1. Filter Berdasarkan Status Validasi Logbook
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 2. Filter Berdasarkan Periode Bulan
        if ($request->filled('bulan') && $request->bulan != 'all') {
            $query->whereMonth('report_date', $request->bulan);
        }

        // 3. Filter Berdasarkan Pencarian Teks (Nama Siswa atau NIS)
        if ($request->filled('search')) {
            $searchIds = SiswaMagang::where('nama_lengkap', 'like', '%' . $request->search . '%')
                                    ->orWhere('nis', 'like', '%' . $request->search . '%')
                                    ->pluck('id_user');
            $query->whereIn('id_user', $searchIds);
        }

        // 4. Filter Berdasarkan Status Akun (Aktif/Nonaktif)
        // Defaultnya kita tampilkan semua ('all') jika tidak ada request.
        if ($request->filled('status_akun') && $request->status_akun != 'all') {
            $akunIds = SiswaMagang::where('status', $request->status_akun)->pluck('id_user');
            $query->whereIn('id_user', $akunIds);
        }

        $logs = $query->orderBy('report_date', 'desc')->paginate(20)->withQueryString();

        foreach ($logs as $log) {
            $siswa = SiswaMagang::where('id_user', $log->id_user)->first();
            $log->nama_siswa = $siswa ? $siswa->nama_lengkap : 'Unknown';
            $log->foto_profil = $siswa ? $siswa->foto_profil : null;
            $log->status_akun = $siswa ? $siswa->status : 'Nonaktif'; // Bawa status akun untuk badge di blade

            $namaPem = 'Admin'; // Default jika tidak ditemukan
            if ($siswa && $siswa->id_pembimbing) {
                $pembimbing = Pembimbing::where('id_pembimbing', $siswa->id_pembimbing)->first();
                if ($pembimbing) {
                    $namaPem = $pembimbing->nama_lengkap ?? $pembimbing->nama_pembimbing ?? null;

                    if (!$namaPem) {
                        $userPem = User::where('id_user', $pembimbing->id_user)->first();
                        $namaPem = $userPem ? ($userPem->nama_lengkap ?? $userPem->name ?? $userPem->username ?? 'Admin') : 'Admin';
                    }
                }
            }
            $log->nama_pembimbing = $namaPem;
        }

        $daftarBulan = [];
        for ($i = 0; $i < 6; $i++) {
            $tgl = Carbon::now()->subMonths($i);
            $daftarBulan[$tgl->format('m')] = $tgl->translatedFormat('F Y');
        }

        return view('admin.log.index', compact('logs', 'daftarBulan'));
    }
}
