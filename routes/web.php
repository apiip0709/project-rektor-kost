<?php

use App\Http\Controllers\Auth\forgetPasswordController;
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

Route::get('/login', [loginController::class, 'index'])->name('login');
Route::post('/loginProcess', [loginController::class, 'login']);
Route::get('/logout', [loginController::class, 'logout']);

// Forget Password
Route::get('/forget-password', [forgetPasswordController::class , 'index'])->name('forget-password');
Route::post('request-process', [forgetPasswordController::class , 'forgetPasswordRequest'])->name('forgetPassword.request.post');
Route::get('/change-password/{token}', [forgetPasswordController::class , 'indexResetPasswordForm'])->name('forgetPassword.link.get');
Route::post('change-process', [forgetPasswordController::class , 'resetPasswordForm'])->name('forgetPassword.link.post');
