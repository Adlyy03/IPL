<?php

use App\Http\Controllers\Admin\BlokController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GangController;
use App\Http\Controllers\Admin\IuranWargaController;
use App\Http\Controllers\Admin\JenisIuranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\IuranController as WargaIuranController;
use App\Http\Controllers\Warga\NotificationController as WargaNotificationController;
use App\Http\Controllers\Warga\ProfilController as WargaProfilController;
use Illuminate\Support\Facades\Route;

// Halaman Depan / Landing Page Welcome
Route::get('/', fn () => view('welcome'))->name('welcome');

// Route Autentikasi (Tamu / Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route Logout (Harus login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Route Area Admin (/admin/*)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD Master
        Route::resource('gang', GangController::class);
        Route::resource('blok', BlokController::class);
        Route::resource('warga', WargaController::class);
        Route::resource('jenis-iuran', JenisIuranController::class);

        // Generate Tagihan Massal
        Route::get('/iuran-warga/generate', [IuranWargaController::class, 'generateView'])->name('iuran-warga.generate');
        Route::post('/iuran-warga/generate', [IuranWargaController::class, 'generateStore'])->name('iuran-warga.generate.store');

        // Pembayaran Iuran
        Route::post('/iuran-warga/{iuranWarga}/bayar', [IuranWargaController::class, 'bayar'])->name('iuran-warga.bayar');
        Route::post('/iuran-warga/{iuranWarga}/batal-bayar', [IuranWargaController::class, 'batalBayar'])->name('iuran-warga.batal-bayar');

        // CRUD Transaksi Iuran Warga
        Route::resource('iuran-warga', IuranWargaController::class);

        // Laporan Keuangan IPL & Ekspor
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

// Route Area Warga (/warga/*)
Route::middleware(['auth', 'role:warga'])
    ->prefix('warga')
    ->name('warga.')
    ->group(function () {
        Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/iuran', [WargaIuranController::class, 'index'])->name('iuran.index');
        Route::get('/iuran/{iuranWarga}', [WargaIuranController::class, 'show'])->name('iuran.show');

        // Profil Warga
        Route::get('/profil', [WargaProfilController::class, 'show'])->name('profil.show');
        Route::put('/profil', [WargaProfilController::class, 'update'])->name('profil.update');

        // Notifikasi Warga
        Route::post('/notifikasi/{id}/baca', [WargaNotificationController::class, 'markAsRead'])->name('notifikasi.baca');
        Route::post('/notifikasi/baca-semua', [WargaNotificationController::class, 'markAllAsRead'])->name('notifikasi.baca-semua');
    });
