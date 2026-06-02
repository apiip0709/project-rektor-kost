<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Auth.login'); // Pastikan path file blade Anda sesuai (resources/views/Auth/login.blade.php)
    }

    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'login_identity' => 'required|string',
            'password'       => 'required|string|min:8',
        ], [
            'login_identity.required' => 'Email atau Nomor Telepon wajib diisi.',
            'password.required'       => 'Kata sandi wajib diisi.',
            'password.min'            => 'Kata sandi minimal harus 8 karakter.',
        ]);

        // 2. Deteksi apakah input berupa Email atau Nomor Telepon
        $identity = $request->input('login_identity');
        
        // Memeriksa format, jika berformat email pakai field 'email', jika tidak anggap sebagai 'phone'
        $fieldType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // 3. Menyusun kredensial untuk dicocokkan ke database
        $credentials = [
            $fieldType  => $identity,
            'password'  => $request->input('password'),
        ];

        // 4. Proses Autentikasi ke Guard Laravel
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Jika sukses login, regenerasi session keamanan
            $request->session()->regenerate();

            // Alihkan ke halaman dashboard / halaman utama aplikasi Anda
            return redirect()->intended('/dashboard')
                             ->with('success', 'Selamat datang kembali!');
        }

        // 5. Jika gagal login, kembalikan ke form dengan pesan error
        return back()->withErrors([
            'login_identity' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ])->withInput($request->only('login_identity'));
    }

    /**
     * Placeholder Method login Pihak Ketiga (Sesuai kebutuhan route Anda)
     */
    public function redirectToGoogle() { /* Logika redirect ke Google API */ }
    public function handleGoogleCallback() { /* Logika callback data Google */ }
    
    public function redirectToWhatsApp() { /* Logika redirect ke WA/Gateway API */ }
    public function handleWhatsAppCallback() { /* Logika callback data WA */ }
}
