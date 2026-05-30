<?php

namespace App\Http\Controllers\Tendik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tendik;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data tendik yang sedang login beserta relasinya yang lengkap
        $tendik = Tendik::with(['user', 'unitKerja', 'pangkatGolongan.pangkat', 'pangkatGolongan.golongan', 'jabatan', 'agama', 'pendidikanTerakhir'])
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('tendik.profil.index', compact('tendik'));
    }
}
