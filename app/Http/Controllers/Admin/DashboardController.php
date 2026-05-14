<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Wajib dipanggil untuk mengambil sesi login

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data user yang sedang login saat ini
        $user = Auth::user();

        // Lempar ke view, dan bawa data $user menggunakan compact()
        return view('admin.dashboard.index', compact('user'));
    }
}
