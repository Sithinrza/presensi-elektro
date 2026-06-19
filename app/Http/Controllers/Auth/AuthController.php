<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaMagang;
use App\Models\Tendik;
use App\Models\Pembimbing;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roleName = strtolower($user->roles->first()->name ?? '');

            // =========================================================
            // 🚨 SAKLAR PENGAMAN: CEK STATUS AKUN NONAKTIF
            // =========================================================
            $statusAkun = 'aktif';
            if ($roleName == 'tendik') {
                $dataTendik = Tendik::where('id_user', $user->id_user)->first();
                $statusAkun = $dataTendik->status ?? 'aktif';
            } elseif (in_array($roleName, ['siswa', 'siswa magang'])) {
                $dataSiswa = SiswaMagang::where('id_user', $user->id_user)->first();
                $statusAkun = $dataSiswa->status ?? 'aktif';
            } elseif ($roleName == 'pembimbing') {
                $dataPembimbing = Pembimbing::where('id_user', $user->id_user)->first();
                $statusAkun = $dataPembimbing->status ?? 'aktif';
            }

            // Jika statusnya Nonaktif, tentang kembali ke halaman login!
            if (strtolower($statusAkun) == 'nonaktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Admin.',
                ])->onlyInput('email');
            }
            // =========================================================

            $request->session()->regenerate();

            switch ($roleName) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'pembimbing':
                    return redirect()->route('pembimbing.dashboard');
                case 'tendik':
                    return redirect()->route('tendik.dashboard');
                case 'siswa magang':
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Akun tidak memiliki hak akses yang valid.'])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
