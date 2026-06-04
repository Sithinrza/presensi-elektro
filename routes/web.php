<?php

use Illuminate\Support\Facades\Route;

// Import Controller Global
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\RiwayatController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TendikController;
use App\Http\Controllers\Admin\SiswaMagangController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\UnitKerjaController;
use App\Http\Controllers\Admin\HariLiburController;
use App\Http\Controllers\Admin\LogController as AdminLog;
use App\Http\Controllers\Admin\RiwayatController as AdminRiwayat;
use App\Http\Controllers\Admin\KlaimController as AdminKlaim;

// Import Controller Siswa
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\LogController as SiswaLog;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayat;
use App\Http\Controllers\Siswa\ProfilController as SiswaProfil;

// Import Controller Pembimbing
use App\Http\Controllers\Pembimbing\DashboardController as PembimbingDashboard;
use App\Http\Controllers\Pembimbing\PresensiSiswaController;
use App\Http\Controllers\Pembimbing\ReportMonitoringController;
use App\Http\Controllers\Pembimbing\NilaiController;

// Import Controller Tendik
use App\Http\Controllers\Tendik\RiwayatController as TendikRiwayat;
use App\Http\Controllers\Tendik\DashboardController as TendikDashboard;
use App\Http\Controllers\Tendik\ProfilController as TendikProfil;


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
    Route::post('/presensi/ajukan-klaim', [PresensiController::class, 'ajukanKlaim'])->name('presensi.ajukan-klaim');


    Route::get('/presensi/{id}/detail', [PresensiController::class, 'show'])->name('presensi.detail');
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

        // Rute untuk mengelola Klaim Lupa CO (Khusus Admin)
        Route::get('/klaim', [AdminKlaim::class, 'index'])->name('klaim.index');
        Route::post('/klaim/{id_klaim}', [AdminKlaim::class, 'verifikasi'])->name('klaim.verifikasi');

        Route::get('/log', [AdminLog::class, 'index'])->name('log');

        Route::get('/riwayat-presensi/cetak/{id_user}', [AdminRiwayat::class, 'cetakPdf'])->name('riwayat.cetak');
        Route::get('/riwayat-presensi/export-excel', [AdminRiwayat::class, 'exportExcel'])->name('riwayat.excel');
    });

    // ------------------------------------------
    // AREA SISWA MAGANG
    // ------------------------------------------
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
        Route::post('/lengkapi-profil', [SiswaDashboard::class, 'simpanProfilLengkap'])->name('lengkapi.profil');
        Route::get('/log', [SiswaLog::class, 'index'])->name('log');
        Route::post('/log', [SiswaLog::class, 'store'])->name('log.store');


        Route::get('/profil', [SiswaProfil::class, 'index'])->name('profil.index');
        Route::put('/profil/update', [SiswaProfil::class, 'update'])->name('profil.update');
        Route::put('/profil/update-foto', [SiswaProfil::class, 'updateFoto'])->name('profil.update-foto');
        Route::delete('/profil/hapus-foto', [SiswaProfil::class, 'deleteFoto'])->name('profil.delete-foto');
    });

    // ------------------------------------------
    // AREA PEMBIMBING
    // ------------------------------------------
    Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/dashboard', [PembimbingDashboard::class, 'index'])->name('dashboard');

        // Monitoring Logbook
        Route::get('/monitoring', [ReportMonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('/monitoring/siswa/{id}', [ReportMonitoringController::class, 'show'])->name('monitoring.show');
        Route::post('/monitoring/validasi/{id}', [ReportMonitoringController::class, 'validasi'])->name('monitoring.validasi');

        // Presensi Siswa (Dibuat eksplisit agar rutenya terdaftar dengan pasti)
        Route::get('/presensi-siswa', [PresensiSiswaController::class, 'index'])->name('presensi-siswa.index');
        Route::get('/presensi-siswa/{id}', [PresensiSiswaController::class, 'show'])->name('presensi-siswa.show');

        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/nilai/create/{id_siswa}', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/nilai/store', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/nilai/edit/{id_siswa}', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/update/{id_siswa}', [NilaiController::class, 'update'])->name('nilai.update');
        Route::get('/nilai/cetak/{id_siswa}', [NilaiController::class, 'cetakSertifikat'])->name('nilai.cetak');
        });

    // ------------------------------------------
    // AREA TENDIK
    // ------------------------------------------
    Route::prefix('tendik')->name('tendik.')->group(function () {
        Route::get('/dashboard', [TendikDashboard::class, 'index'])->name('dashboard');
        Route::post('/lengkapi-profil', [TendikDashboard::class, 'lengkapiProfil'])->name('lengkapi.profil');
        Route::get('/profil', [TendikProfil::class, 'index'])->name('profil.index');
        Route::put('/profil/update', [TendikProfil::class, 'update'])->name('profil.update');
        Route::put('/profil/update-foto', [TendikProfil::class, 'updateFoto'])->name('profil.update-foto');
        Route::delete('/tendik/profil/hapus-foto', [TendikProfil::class, 'deleteFoto'])->name('profil.delete-foto');
        });

});
