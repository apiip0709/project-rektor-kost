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
    // Sudah cocok 100% dengan Blade dan Controller
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.process');
    Route::post('/register/send-otp', [RegisterController::class, 'sendOtp'])->name('register.otp');

    // --- AUTENTIKASI PIHAK KETIGA (SOSIAL MEDIA) ---
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

    // Mengantisipasi jika nanti ada integrasi tombol "Daftar/Masuk Langsung dengan WA" tanpa OTP
    Route::get('/auth/whatsapp', [LoginController::class, 'redirectToWhatsApp'])->name('auth.whatsapp');
    Route::get('/auth/whatsapp/callback', [LoginController::class, 'handleWhatsAppCallback']);
});

// --- FITUR KELUAR (LOGOUT) ---
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
