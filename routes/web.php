<?php

use App\Http\Controllers\Auth\registerController;
use App\Http\Controllers\Auth\loginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('visitor.pages.welcome');
});

Route::get('/kost/{id}', function ($id) {
    return view('visitor.pages.detail', ['id' => $id]);
})->name('kost.detail');

Route::get('/dashboard', function () {
    return view('owner.pages.dashboard');
})->name('dashboard');
Route::get('/kelola-kamar', function () {
    return view('owner.pages.kelola-room');
})->name('kelola');
Route::get('/tambah-kamar', function () {
    return view('owner.pages.tambah-room');
})->name('tambah');

Route::middleware('guest')->group(function () {
    
    // --- FITUR MASUK (LOGIN) ---
    // Menampilkan halaman Form Login (Card Masuk)
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Memproses data form login yang dikirim user (Diberi nama 'login.process')
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');

    // --- FITUR DAFTAR (REGISTER) ---
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.process');
    Route::post('/register/send-otp', [RegisterController::class, 'sendOtp'])->name('register.otp');

    // --- AUTENTIKASI PIHAK KETIGA (SOSIAL MEDIA) ---
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

    Route::get('/auth/whatsapp', [LoginController::class, 'redirectToWhatsApp'])->name('auth.whatsapp');
    Route::get('/auth/whatsapp/callback', [LoginController::class, 'handleWhatsAppCallback']);
});

