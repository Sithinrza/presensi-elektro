<?php

use Illuminate\Support\Facades\Route;

// Import Controller Global
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TendikController;
use App\Http\Controllers\Admin\SiswaMagangController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\UnitKerjaController;
use App\Http\Controllers\Admin\HariLiburController;
use App\Http\Controllers\Admin\LogController as AdminLog;
use App\Http\Controllers\Admin\RiwayatController as AdminRiwayat;
use App\Http\Controllers\Admin\HariLiburController as HariLibur;

// Import Controller Siswa
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\LogController as SiswaLog;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfile;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayat;

// Import Controller Pembimbing
use App\Http\Controllers\Pembimbing\DashboardController as PembimbingDashboard;
use App\Http\Controllers\Pembimbing\ReportMonitoringController;
use App\Http\Controllers\RiwayatController;
// Import Controller Tendik
use App\Http\Controllers\Tendik\ProfileController as TendikProfile;
use App\Http\Controllers\Tendik\RiwayatController as TendikRiwayat;
use App\Http\Controllers\Tendik\DashboardController as TendikDashboard;

// ==========================================
// PUBLIC ROUTES (Tidak Perlu Login)
// ==========================================
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// JALUR TERPROTEKSI (PAGAR UTAMA: WAJIB LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // ------------------------------------------
    // PRESENSI GLOBAL
    // ------------------------------------------
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::post('/presensi-submit', [PresensiController::class, 'store'])->name('presensi.store');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('presensi.riwayat-presensi');
    // ------------------------------------------
    // AREA ADMIN
    // ------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::prefix('data')->name('data.')->group(function () {
            Route::resource('tendik', TendikController::class);
            Route::resource('siswa', SiswaMagangController::class);
            Route::resource('pembimbing', PembimbingController::class);
        });

        Route::resource('unit-kerja', UnitKerjaController::class);
        Route::resource('hari-libur', HariLiburController::class);

        Route::get('/riwayat-presensi', [AdminRiwayat::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat-presensi/detail/{id_user}', [AdminRiwayat::class, 'showDetail'])->name('riwayat.detail');

        //ini sementara
        Route::get('/log', [AdminLog::class, 'index'])->name('log');
        Route::get('/hari-libur', [HariLibur::class, 'index'])->name('hari-libur');
    });

    // ------------------------------------------
    // AREA SISWA MAGANG
    // ------------------------------------------
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
        Route::post('/lengkapi-profil', [SiswaDashboard::class, 'simpanProfilLengkap'])->name('lengkapi.profil');
        Route::get('/log', [SiswaLog::class, 'index'])->name('log');

    });

    // ------------------------------------------
    // AREA PEMBIMBING
    // ------------------------------------------
    Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/dashboard', [PembimbingDashboard::class, 'index'])->name('dashboard');
        Route::get('/monitoring', [ReportMonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('/monitoring/show', [ReportMonitoringController::class, 'show'])->name('monitoring.show');
    });

    // ------------------------------------------
    // AREA TENDIK
    // ------------------------------------------
    Route::prefix('tendik')->name('tendik.')->group(function () {
        Route::get('/dashboard', [TendikDashboard::class, 'index'])->name('dashboard');
        Route::post('/lengkapi-profil', [TendikDashboard::class, 'lengkapiProfil'])->name('lengkapi.profil');

        // Route::get('/profile', [TendikProfile::class, 'index'])->name('profile');
        // Route::get('/riwayat-presensi', [TendikRiwayat::class, 'index'])->name('riwayat');
    });

}); // <-- PERHATIKAN: Kurung tutup pagar auth-nya dipindah ke ujung paling bawah sini!
