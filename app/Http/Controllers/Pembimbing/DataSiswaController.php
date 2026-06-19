<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaMagang;
use App\Models\Pembimbing;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->first();

        if (!$pembimbing) {
            return redirect()->route('login')->with('error', 'Profil pembimbing tidak ditemukan.');
        }

        // Kunci query HANYA untuk anak bimbingannya sendiri
        $query = SiswaMagang::with(['user', 'agama'])
                            ->where('id_pembimbing', $pembimbing->id_pembimbing);

        // 1. Filter Pencarian Teks (Nama Siswa atau NIS)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Berdasarkan Status Akun (Aktif/Nonaktif)
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // 3. Urutkan Aktif duluan, lalu nama, lalu Pagination
        $siswa = $query->orderBy('status', 'asc')
                       ->orderBy('nama_lengkap', 'asc')
                       ->paginate(10)->withQueryString();

        return view('pembimbing.data-siswa.index', compact('siswa'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $pembimbing = Pembimbing::where('id_user', $user->id_user)->firstOrFail();

        // Ambil detail siswa dan pastikan dia adalah anak bimbingannya (keamanan)
        $siswa = SiswaMagang::with(['user', 'agama'])
            ->where('id_pembimbing', $pembimbing->id_pembimbing)
            ->where('id_siswa', $id)
            ->firstOrFail();

        return view('pembimbing.data-siswa.show', compact('siswa'));
    }
}
