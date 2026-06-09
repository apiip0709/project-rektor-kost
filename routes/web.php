<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
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
        Route::get('/superadmin/dashboard', function () {
            return "Halaman Dashboard Superadmin";
        })->name('superadmin.dashboard');
    });
    
    // ─── KELOMPOK ROLE: ADMIN ───
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return "Halaman Dashboard Admin";
        })->name('admin.dashboard');
    });
    
    // ─── KELOMPOK ROLE: PEMILIK KOST ───
    Route::middleware('role:pemilik')->group(function () {
        Route::get('/dashboard', function () {
            return view('owner.pages.dashboard');
        })->name('dashboard');

        Route::get('/kelola-kamar', function () {
            return view('owner.pages.kelola-room');
            })->name('kelola');

        Route::get('/tambah-kamar', function () {
            return view('owner.pages.tambah-room');
        })->name('tambah');
    });

    // ─── KELOMPOK ROLE: PENGGUNA (PENCARI KOST) ───
    Route::middleware('role:pengguna')->group(function () {
        Route::get('/user/profil', function () {
            return "Halaman Profil Pencari Kost";
        })->name('user.profile');
    });



});
