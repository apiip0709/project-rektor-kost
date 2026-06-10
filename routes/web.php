<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\UserController;
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
    // Menghapus 'auth' ganda, menyisakan role:superadmin
    Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        

        Route::resource('user', UserController::class);
        Route::resource('owner', OwnerController::class);
        Route::resource('kost', KostController::class);
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
        // Route::resource('room', RoomController::class);
        
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
