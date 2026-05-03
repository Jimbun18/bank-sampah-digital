<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\JenisSampah;

// Halaman Landing Page (PASTIKAN ADA ->name('landing') DI SINI)
Route::get('/', function () {
    $jenis_sampahs = \App\Models\JenisSampah::all(); 
    
    // Kirim ke tampilan landing.blade.php
    return view('landing', compact('jenis_sampahs'));
})->name('landing');

// Route untuk Login & Register (Hanya bisa diakses tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    
    // Tambahkan 2 baris ini untuk Register
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister']);
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::get('/verify-otp', [\App\Http\Controllers\AuthController::class, 'showVerifyOtp']);
    Route::post('/verify-otp', [\App\Http\Controllers\AuthController::class, 'verifyOtp']);

    // Rute Lupa Password
    Route::get('/forgot-password', [\App\Http\Controllers\AuthController::class, 'showForgotPassword']);
    Route::post('/forgot-password', [\App\Http\Controllers\AuthController::class, 'sendResetOtp']);
    Route::get('/reset-password', [\App\Http\Controllers\AuthController::class, 'showResetPassword']);
    Route::post('/reset-password', [\App\Http\Controllers\AuthController::class, 'processResetPassword']);
});

// Route Global yang butuh Auth (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    
    // Group Route NASABAH
    Route::middleware('role:nasabah')->prefix('nasabah')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\NasabahController::class, 'dashboard'])->name('nasabah.dashboard');
        
        Route::get('/riwayat', [\App\Http\Controllers\NasabahController::class, 'riwayat'])->name('nasabah.riwayat');
        
        // Route Ajukan Penarikan
        Route::get('/penarikan', [\App\Http\Controllers\NasabahController::class, 'penarikan'])->name('nasabah.penarikan');
        Route::post('/penarikan', [\App\Http\Controllers\NasabahController::class, 'simpanPenarikan'])->name('nasabah.simpan_penarikan');

        // Route Request Jemput
        Route::get('/request-jemput', [\App\Http\Controllers\NasabahController::class, 'requestJemput'])->name('nasabah.request_jemput');
        Route::post('/request-jemput', [\App\Http\Controllers\NasabahController::class, 'simpanRequestJemput'])->name('nasabah.simpan_request_jemput');

        // Route Saldo & Mutasi
        Route::get('/mutasi', [\App\Http\Controllers\NasabahController::class, 'mutasi'])->name('nasabah.mutasi');
    });

    
    // Group Route PETUGAS
    Route::middleware('role:petugas')->prefix('petugas')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\PetugasController::class, 'dashboard'])->name('petugas.dashboard');
        
        // Route Kasir / Setor
        Route::get('/setor', [\App\Http\Controllers\PetugasController::class, 'setor'])->name('petugas.setor');
        Route::post('/setor', [\App\Http\Controllers\PetugasController::class, 'simpanSetor'])->name('petugas.simpan_setor');

        // Route Request Jemput (Masuk)
        Route::get('/request-jemput', [\App\Http\Controllers\PetugasController::class, 'requestJemput'])->name('petugas.request_jemput');
        Route::post('/request-jemput/{id}/proses', [\App\Http\Controllers\PetugasController::class, 'prosesRequestJemput'])->name('petugas.proses_request_jemput');

        Route::get('/riwayat-setoran', [\App\Http\Controllers\PetugasController::class, 'riwayatSetoran'])->name('petugas.riwayat');
        Route::get('/riwayat-setoran/export', [\App\Http\Controllers\PetugasController::class, 'exportRiwayat'])->name('petugas.riwayat.export');
    });

    // Group Route ADMIN
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/penarikan', [\App\Http\Controllers\AdminController::class, 'penarikan'])->name('admin.penarikan');
        Route::post('/penarikan/{id}/proses', [\App\Http\Controllers\AdminController::class, 'prosesPenarikan'])->name('admin.proses_penarikan');
        
        // Rute Baru untuk Export
        Route::get('/export-penarikan', [\App\Http\Controllers\AdminController::class, 'exportPenarikan'])->name('admin.export_penarikan');

        // Master Data
        Route::get('/master-data', [\App\Http\Controllers\AdminController::class, 'masterData'])->name('admin.master_data');
        Route::post('/kategori', [\App\Http\Controllers\AdminController::class, 'storeKategori'])->name('admin.store_kategori');
        Route::delete('/kategori/{id}', [\App\Http\Controllers\AdminController::class, 'destroyKategori'])->name('admin.destroy_kategori');
        Route::post('/bank', [\App\Http\Controllers\AdminController::class, 'storeBank'])->name('admin.store_bank');
        Route::delete('/bank/{id}', [\App\Http\Controllers\AdminController::class, 'destroyBank'])->name('admin.destroy_bank');
        // Tambahkan ini di bawah rute store dan destroy kategori milikmu
        Route::put('/master-data/kategori/{id}', [\App\Http\Controllers\AdminController::class, 'updateKategori'])->name('admin.kategori.update');

        // Data Pengguna
        Route::get('/data-pengguna', [\App\Http\Controllers\AdminController::class, 'dataPengguna'])->name('admin.data_pengguna');
        Route::post('/data-pengguna/{id}/reset-password', [\App\Http\Controllers\AdminController::class, 'resetPassword'])->name('admin.reset_password');
        Route::post('/data-pengguna/simpan', [\App\Http\Controllers\AdminController::class, 'storePengguna'])->name('admin.pengguna.store');

        // Laporan Sampah
        Route::get('/laporan-sampah', [\App\Http\Controllers\AdminController::class, 'laporanSampah'])->name('admin.laporan_sampah');
        Route::get('/laporan-sampah/export', [\App\Http\Controllers\AdminController::class, 'exportLaporanSampah'])->name('admin.laporan_sampah.export');

        // Pastikan letaknya di dalam grup middleware admin ya
        Route::put('/penarikan/tolak/{id}', [\App\Http\Controllers\AdminController::class, 'tolakPenarikan'])->name('admin.penarikan.tolak');
    });

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    });
});