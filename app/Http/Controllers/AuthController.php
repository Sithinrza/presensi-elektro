<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Memproses data login yang dikirim dari form
    public function authenticate(Request $request)
    {
        // Validasi inputan form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba cocokkan dengan database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil data user yang sedang login saat ini
            $user = Auth::user();

            // Ambil nama role milik user tersebut dari database
            // (Mengambil role pertama karena umumnya 1 akun = 1 role)
            $roleName = $user->roles->first()->name ?? '';

            // PERCABANGAN REDIRECT BERDASARKAN ROLE
            // Kita ubah ke huruf kecil semua (strtolower) agar tidak sensitif huruf besar/kecil
            switch (strtolower($roleName)) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');

                case 'pembimbing':
                    return redirect()->intended('/pembimbing/dashboard');

                case 'tendik':
                    return redirect()->intended('/tendik/dashboard');

                case 'siswa magang': // Sesuaikan dengan tulisan di RoleSeeder-mu (misal 'siswa' atau 'siswa magang')
                case 'siswa':
                    return redirect()->intended('/siswa/dashboard');

                default:
                    // Jika role-nya aneh atau tidak ada, logout paksa demi keamanan
                    Auth::logout();
                    return back()->withErrors(['email' => 'Akun tidak memiliki hak akses yang valid.'])->onlyInput('email');
            }
        }

        // Kalau gagal login (password/email salah), kembalikan ke form bawa pesan error
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
