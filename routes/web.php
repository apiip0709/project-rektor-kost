<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// 🟢 AKSES UMUM (Pengunjung biasa / Belum Login)
Route::get('/', function () {
    return view('visitor.pages.welcome');
})->name('home');

Route::get('/kost/{id}', function ($id) {
    return view('visitor.pages.detail', ['id' => $id]);
})->name('kost.detail');


// 🟡 AKSES HANYA UNTUK GUEST (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.process');
    Route::post('/register/send-otp', [RegisterController::class, 'sendOtp'])->name('register.otp');

    // OAuth & Otomasi Sosial Media
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
    Route::get('/auth/whatsapp/redirect', [LoginController::class, 'redirectToWhatsapp'])->name('login.whatsapp.redirect');
    Route::get('/auth/whatsapp/callback', [LoginController::class, 'handleWhatsappCallback'])->name('login.whatsapp.callback');
});


// 🔴 AKSES SETELAH LOGIN (Wajib Autentikasi)
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ─── KELOMPOK ROLE: SUPERADMIN ───
    Route::middleware('role:superadmin')->group(function () {

        Route::get('/dashboard-admin', [SuperadminController::class, 'dashboard'])
            ->name('superadmin.dashboard');

        Route::prefix('superadmin')->name('superadmin.')->group(function () {

            // 1. Rute Index Utama dihandle SuperadminController (Untuk Tabel & Search)
            Route::get('/user', [SuperadminController::class, 'userIndex'])->name('user.index');
            Route::get('/owner', [SuperadminController::class, 'ownerIndex'])->name('owner.index');
            Route::get('/kost', [SuperadminController::class, 'kostIndex'])->name('kost.index');

            // 2. Rute Aksi Sisanya (Show, Edit, Update, Delete) dihandle oleh masing-masing Controller,
            Route::resource('user', UserController::class)->except(['index', 'show']);
            Route::resource('kost', KostController::class)->except(['index']);
            Route::post('kost/room/{kost_id}', [KostController::class, 'storeRoom'])->name('kost.storeRoom');
            Route::resource('owner', OwnerController::class)->except(['index']);
            Route::put('/owner/{owner_id}/update-status', [OwnerController::class, 'updateStatus'])->name('owner.updateStatus');
        });
    });

    // ─── KELOMPOK ROLE: TEKNISI (Role baru Anda dari tabel users) ───
    Route::middleware('role:teknisi')->prefix('teknisi')->name('teknisi.')->group(function () {
        Route::get('/dashboard', function () {
            return "Halaman Dashboard Teknisi";
        })->name('dashboard');
    });

    // ─── KELOMPOK ROLE: PEMILIK KOST ───
    Route::middleware('role:pemilik')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', function () {
            return view('owner.pages.dashboard');
        })->name('dashboard');

        // 🌟 KUNCI PERUBAHAN: Pasang Resource Kost & Room untuk Pemilik di sini
        // Menggunakan Controller yang sama dengan Superadmin, tapi URL-nya nanti /owner/kost
        Route::resource('kost', KostController::class);

        // Route manual Anda untuk kamar bisa pelan-pelan dialihkan ke Resource di atas agar CRUD-nya otomatis
        Route::get('/kelola-kamar', function () {
            return view('owner.pages.kelola-room');
        })->name('kelola');
    });

    // ─── KELOMPOK ROLE: PENGGUNA (PENCARI KOST) ───
    Route::middleware('role:pengguna')->prefix('user')->name('user.')->group(function () {
        Route::get('/profil', function () {
            return "Halaman Profil Pencari Kost";
        })->name('profile');
    });
});
