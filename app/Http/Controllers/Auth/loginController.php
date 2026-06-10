<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Auth.login');
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

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'superadmin' || $user->role === 'admin') {
                return redirect()->intended(route('superadmin.dashboard'))
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
    {
        $targetUrl = Socialite::driver('google')->redirect()->getTargetUrl();
        $forcedUrl = $targetUrl . '&prompt=select_account';
        return redirect()->away($forcedUrl);
    }

    // 🌟 PERBAIKAN: Menambahkan Request $request ke dalam parameter method
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                return redirect()->route('register')
                    ->withInput([
                        'email' => $googleUser->getEmail(),
                        'name'  => $googleUser->getName()
                    ])
                    ->with('error', 'Akun Google Anda belum terdaftar. Silakan lakukan pendaftaran terlebih dahulu.');
            }

            Auth::login($user);

            // Menggunakan objek $request yang valid dari parameter injector
            $request->session()->regenerate();

            // SINKRONISASI: Arahkan ke dashboard jika admin, atau home jika user biasa
            if ($user->role === 'superadmin' || $user->role === 'admin') {
                return redirect()->route('superadmin.dashboard')->with('success', 'Berhasil masuk sebagai Admin!');
            }

            return redirect()->route('home')->with('success', 'Berhasil masuk menggunakan akun Google!');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'login_identity' => 'Gagal melakukan otentikasi menggunakan Google. Silakan coba lagi.',
            ]);
        }
    }

    public function redirectToWhatsapp()
    {
        $verificationCode = 'REKTORKOST-' . strtoupper(Str::random(6));

        Cache::put('wa_login_' . $verificationCode, 'pending', 300);

        $nomorTarget = '6289695096085';

        $pesanTeks = "Halo Rektor Kost, saya ingin masuk ke sistem\n\nKode: " . $verificationCode;

        $urlWhatsapp = "https://wa.me/" . $nomorTarget . "?text=" . urlencode($pesanTeks);

        return redirect()->away($urlWhatsapp);
    }

    public function handleWhatsappCallback(Request $request)
    {
        $phoneFromWa = $request->query('phone');

        if (!$phoneFromWa) {
            return redirect()->route('login')->with('error', 'Akses verifikasi WhatsApp tidak valid.');
        }

        $phoneFormatted = $phoneFromWa;
        if (strpos($phoneFromWa, '62') === 0) {
            $phoneFormatted = '0' . substr($phoneFromWa, 2);
        } elseif (strpos($phoneFromWa, '+62') === 0) {
            $phoneFormatted = '0' . substr($phoneFromWa, 3);
        }

        $user = User::where('phone', $phoneFormatted)->first();

        if (!$user) {
            return redirect()->route('register')
                ->withInput([
                    'phone' => $phoneFormatted,
                    'register_method' => 'whatsapp'
                ])
                ->with('error', 'Nomor WhatsApp Anda belum terdaftar. Silakan lakukan pendaftaran terlebih dahulu.');
        }

        Auth::login($user);
        $request->session()->regenerate(); // Tambahkan regenerasi session demi keamanan

        // SINKRONISASI RUTE REDIRECT
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('home');
    }
}
