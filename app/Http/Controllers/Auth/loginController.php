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
        $request->validate([
            'login_identity' => 'required|string',
            'password'       => 'required|string|min:8',
        ], [
            'login_identity.required' => 'Email atau Nomor Telepon wajib diisi.',
            'password.required'       => 'Kata sandi wajib diisi.',
            'password.min'            => 'Kata sandi minimal harus 8 karakter.',
        ]);

        $identity = $request->input('login_identity');

        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } else {
            $fieldType = 'phone';
            if (strpos($identity, '62') === 0) {
                $identity = '0' . substr($identity, 2);
            } elseif (strpos($identity, '+62') === 0) {
                $identity = '0' . substr($identity, 3);
            }
        }

        $credentials = [
            $fieldType => $identity,
            'password' => $request->input('password'),
        ];

        // 4. Proses Autentikasi ke Guard Laravel
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang Admin!');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'login_identity' => 'Email/Nomor Telepon atau Kata Sandi salah.',
        ])->withInput($request->only('login_identity'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar sistem.');
    }

    public function redirectToGoogle()
    { /* Logika redirect ke Google API */
    }
    public function handleGoogleCallback()
    { /* Logika callback data Google */
    }

    public function redirectToWhatsApp()
    { /* Logika redirect ke WA/Gateway API */
    }
    public function handleWhatsAppCallback()
    { /* Logika callback data WA */
    }
}
