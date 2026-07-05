<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil role user dari relasi (Sama persis seperti di AuthController)
        $userRole = strtolower(Auth::user()->roles->first()->name ?? '');

        // 3. Ubah semua parameter role yang diizinkan menjadi huruf kecil agar gampang dicocokkan
        $allowedRoles = array_map('strtolower', $roles);

        // 4. Jika role user ada di dalam daftar yang diizinkan, silakan masuk!
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        // 5. Jika memaksa masuk ke rute yang bukan haknya, lempar error 403
        abort(403, 'AKSES DITOLAK! Anda tidak memiliki izin untuk membuka halaman ini.');
    }
}
