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

// Import Controller Siswa
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\LogController;

// Import Controller Pembimbing
use App\Http\Controllers\Pembimbing\DashboardController as PembimbingDashboard;
use App\Http\Controllers\Pembimbing\ReportMonitoringController;
;
// Import Controller Tendik
use App\Http\Controllers\Tendik\DashboardController as TendikDashboard;


// Utama
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Presensi
Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');

// --- AREA ADMIN ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('tendik', TendikController::class);
    Route::resource('siswa', SiswaMagangController::class);
    Route::resource('pembimbing', PembimbingController::class);
    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('hari-libur', HariLiburController::class);
});

// --- AREA SISWA MAGANG ---
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::resource('log', LogController::class);
});

// --- AREA PEMBIMBING ---
Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
    Route::get('/dashboard', [PembimbingDashboard::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [ReportMonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/show', [ReportMonitoringController::class, 'show'])->name('monitoring.show');
});

// --- AREA TENDIK
Route::prefix('tendik')->name('tendik.')->group(function () {
    Route::get('/dashboard', [TendikDashboard::class, 'index'])->name('dashboard');

});
