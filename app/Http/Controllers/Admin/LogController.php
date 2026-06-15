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

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('bulan') && $request->bulan != 'all') {
            $query->whereMonth('report_date', $request->bulan);
        }

        if ($request->has('search') && $request->search != '') {
            $searchIds = SiswaMagang::where('nama_lengkap', 'like', '%' . $request->search . '%')
                                    ->orWhere('nis', 'like', '%' . $request->search . '%')
                                    ->pluck('id_user');

            $query->whereIn('id_user', $searchIds);
        }

        $logs = $query->orderBy('report_date', 'desc')->paginate(20);

        foreach ($logs as $log) {
            $siswa = SiswaMagang::where('id_user', $log->id_user)->first();
            $log->nama_siswa = $siswa ? $siswa->nama_lengkap : 'Unknown';
            $log->foto_profil = $siswa ? $siswa->foto_profil : null;

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
