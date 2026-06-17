<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {


        $middleware->alias([
            'role' => CheckRole::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            $roleName = $request->user()?->roles->first()->name ?? '';

            switch (strtolower($roleName)) {
                case 'admin':
                    return route('admin.dashboard');
                case 'pembimbing':
                    return route('pembimbing.dashboard');
                case 'tendik':
                    return route('tendik.dashboard');
                case 'siswa magang':
                case 'siswa':
                    return route('siswa.dashboard');
                default:
                    return '/';
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
