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

        // 1. Filter Status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 2. Filter Bulan
        if ($request->has('bulan') && $request->bulan != 'all') {
            $query->whereMonth('report_date', $request->bulan);
        }

        // 3. Filter Pencarian Nama / NIS
        if ($request->has('search') && $request->search != '') {
            // Cari dulu id_user milik siswa yang namanya cocok
            $searchIds = SiswaMagang::where('nama_lengkap', 'like', '%' . $request->search . '%')
                                    ->orWhere('nis', 'like', '%' . $request->search . '%')
                                    ->pluck('id_user');

            $query->whereIn('id_user', $searchIds);
        }

        // Ambil data logbook (pakai paginate agar rapi jika datanya ratusan)
        $logs = $query->orderBy('report_date', 'desc')->paginate(20);

        // Tempelkan nama siswa dan pembimbing ke masing-masing log
        // Tempelkan nama siswa dan pembimbing ke masing-masing log
        foreach ($logs as $log) {
            $siswa = SiswaMagang::where('id_user', $log->id_user)->first();
            $log->nama_siswa = $siswa ? $siswa->nama_lengkap : 'Unknown';

            $namaPem = 'Admin'; // Default jika tidak ditemukan
            if ($siswa && $siswa->id_pembimbing) {
                $pembimbing = Pembimbing::where('id_pembimbing', $siswa->id_pembimbing)->first();
                if ($pembimbing) {
                    // 1. Coba ambil nama langsung dari tabel pembimbing
                    $namaPem = $pembimbing->nama_lengkap ?? $pembimbing->nama_pembimbing ?? null;

                    // 2. Jika di tabel pembimbing tidak ada, cari di tabel users
                    if (!$namaPem) {
                        $userPem = User::where('id_user', $pembimbing->id_user)->first();
                        $namaPem = $userPem ? ($userPem->nama_lengkap ?? $userPem->name ?? $userPem->username ?? 'Admin') : 'Admin';
                    }
                }
            }
            $log->nama_pembimbing = $namaPem;
        }

        // Buat daftar bulan untuk dropdown filter (misal 6 bulan terakhir)
        $daftarBulan = [];
        for ($i = 0; $i < 6; $i++) {
            $tgl = Carbon::now()->subMonths($i);
            $daftarBulan[$tgl->format('m')] = $tgl->translatedFormat('F Y');
        }

        return view('admin.log.index', compact('logs', 'daftarBulan'));
    }
}
