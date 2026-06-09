<?php

// PERBAIKAN: Huruf pertama Controller diubah menjadi Kapital (R dan L)
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('visitor.pages.welcome');
})->name('home');

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
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');

    // --- FITUR DAFTAR (REGISTER) ---
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.process');
    Route::post('/register/send-otp', [RegisterController::class, 'sendOtp'])->name('register.otp');

    // --- AUTENTIKASI PIHAK KETIGA (SOSIAL MEDIA) ---
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

    // --- WHATSAPP LOGIN AUTOMATION ---
    Route::get('/auth/whatsapp/redirect', [LoginController::class, 'redirectToWhatsapp'])->name('login.whatsapp.redirect');
    Route::get('/auth/whatsapp/callback', [LoginController::class, 'handleWhatsappCallback'])->name('login.whatsapp.callback'); // 🌟 Tambahan Baru
});

// --- FITUR KELUAR (LOGOUT) ---
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
