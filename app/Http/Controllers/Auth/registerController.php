<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 1. LOGIKA PENGIRIMAN OTP YANG BERBEDA
    public function sendOtp(Request $request)
    {
        $method = $request->input('register_method');

        if ($method === 'whatsapp') {
            $this->sendWhatsAppOtp($request->email);
        } else {
            $this->sendGoogleSmsOtp($request->phone);
        }

        return response()->json(['success' => true, 'message' => 'OTP berhasil terkirim']);
    }

    // 2. LOGIKA VALIDASI DAN PENYIMPANAN DATA AKHIR
    public function register(Request $request)
    {
        $method = $request->input('register_method');

        // Aturan validasi dasar yang berlaku untuk kedua metode
        $rules = [
            'password' => ['required', 'string', 'min:8'],
            'otp' => ['required', 'numeric'], // Tambahkan validasi kecocokan OTP internal Anda di sini
        ];

        // Pengkondisian aturan validasi berdasarkan metode pendaftaran
        if ($method === 'whatsapp') {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        } else {
            $rules['phone'] = ['required', 'string', 'min:10', 'unique:users'];
        }

        $request->validate($rules);

        // Buat Akun Pengguna Baru
        $user = User::create([
            'name' => $method === 'whatsapp' ? explode('@', $request->email)[0] : 'User '.$request->phone,
            'email' => $method === 'whatsapp' ? $request->email : null,
            'phone' => $method === 'google' ? $request->phone : null,
            'password' => Hash::make($request->password),
            'role' => 'owner',
        ]);

        Auth::login($user);

        return redirect()->route('owner.dashboard')->with('success', 'Pendaftaran Akun Berhasil!');
    }
}
