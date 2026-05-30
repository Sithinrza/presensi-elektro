<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data siswa yang sedang login beserta relasinya
        $siswa = SiswaMagang::with(['user', 'pembimbing', 'agama'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('siswa.profil.index', compact('siswa'));
    }
}
