<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /**
     * Menampilkan Form Registrasi
     */
    public function showRegisterForm()
    {
        return view('Auth.register');
    }

    /**
     * Memproses Pendaftaran Akun Baru
     */
    public function register(Request $request)
    {
        $method = $request->input('register_method');

        $rules = [
            'password' => 'required|string|min:8',
            'otp'      => 'required|string|size:6',
        ];

        if ($method === 'google') {
            $rules['email'] = 'required|email|unique:users,email';
        } elseif ($method === 'whatsapp') {
            $rules['phone'] = 'required|numeric|unique:users,phone';

            if ($request->filled('email')) {
                $rules['email'] = 'nullable|email|unique:users,email';
            }
        } else {
            return back()->withErrors(['register_method' => 'Silahkan pilih metode pendaftaran terlebih dahulu.']);
        }

        $request->validate($rules, [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email/Gmail ini sudah terdaftar di sistem. Silakan gunakan email lain atau masuk.',
            'phone.required'    => 'Nomor telepon wajib diisi.',
            'phone.numeric'     => 'Nomor telepon harus berupa angka.',
            'phone.unique'      => 'Nomor telepon ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'otp.required'      => 'Kode OTP wajib diisi.',
            'otp.size'          => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        $sessionOtp = session('generated_otp');

        if (!$sessionOtp || $request->input('otp') !== $sessionOtp) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah atau telah kedaluwarsa.'])->withInput();
        }

        if ($method === 'google' && $request->filled('email')) {
            // Ambil string sebelum '@' dari Gmail
            $generatedName = strstr($request->input('email'), '@', true);
        } else {
            $generatedName = 'User-' . substr($request->input('phone'), -4);
        }

        User::create([
            'name'            => $generatedName,
            'email'           => $request->filled('email') ? $request->input('email') : null,
            'phone'           => $request->filled('phone') ? $request->input('phone') : null,
            'password'        => Hash::make($request->input('password')),
            'register_method' => $method,
            'role'            => 'pengguna',
        ]);

        session()->forget('generated_otp');
        return redirect()->route('login')->with('success', 'Akun Anda berhasil didaftarkan! Silakan masuk.');
    }

    /**
     * Handle Request AJAX / Interaksi tombol untuk Kirim OTP
     */
    public function sendOtp(Request $request)
    {
        $method = $request->input('register_method');

        // 1. SINKRONISASI LOGIKA VALIDASI SEBELUM KIRIM OTP
        if ($method === 'google') {
            // Jalur Google wajib pakai Gmail
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email'
            ], [
                'email.required' => 'Email wajib diisi sebelum mengirim OTP.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email ini sudah terdaftar.'
            ]);
        } else {
            // Jalur WhatsApp wajib pakai nomor HP
            $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric|unique:users,phone'
            ], [
                'phone.required' => 'Nomor telepon wajib diisi sebelum mengirim OTP.',
                'phone.numeric'  => 'Nomor telepon harus berupa angka.',
                'phone.unique'   => 'Nomor telepon ini sudah terdaftar.'
            ]);
        }

        // Gagal validasi langsung di-return di awal (Early Return Pattern)
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // 2. Generate 6 digit angka acak
        $otpCode = (string) rand(100000, 999999);
        session(['generated_otp' => $otpCode]);

        // 3. Buat variabel penampung untuk response data dan status code
        $responseData = [];
        $statusCode = 200;

        // 4. SINKRONISASI LOGIKA PENGIRIMAN OTP
        if ($method === 'google') {
            try {
                Mail::to($request->input('email'))->send(new SendOtpMail($otpCode));

                $responseData = [
                    'success' => true,
                    'message' => 'Kode OTP berhasil dikirim ke email Anda!'
                ];
            } catch (\Exception $e) {
                $responseData = [
                    'success' => false,
                    'message' => 'Gagal mengirim email. Pastikan pengaturan SMTP .env sudah benar.'
                ];
                $statusCode = 500;
            }
        } else {
            // JALUR WHATSAPP: KIRIM OTP KE WHATSAPP VIA API FONNTE
            try {
                // Ambil nomor telepon dari request
                $phone = $request->input('phone');

                // FORMATTING OTOMATIS: Mengubah awalan '08' menjadi '62'
                if (strpos($phone, '0') === 0) {
                    $phone = '62' . substr($phone, 1);
                }

                $messageTemplate = "*REKTOR KOST*\n\n" .
                    "Halo! Kode OTP pendaftaran akun Anda adalah: *{$otpCode}*\n\n" .
                    "Kode ini hanya berlaku selama 5 menit. Demi keamanan akun Anda, " .
                    "jangan sebarkan kode ini kepada siapa pun termasuk pihak Rektor Kost.";

                $response = Http::withHeaders([
                    'Authorization' => env('WA_GATEWAY_TOKEN'), // Token diatur di file .env
                ])->post('https://api.fonnte.com/send', [
                    'target'  => $phone,
                    'message' => $messageTemplate, // 🌟 Diarahkan ke variabel template di atas
                ]);

                // CEK RESPONS DARI SERVER FONNTE
                $result = $response->json();

                if (isset($result['status']) && $result['status'] === false) {
                    $responseData = [
                        'success' => false,
                        'message' => 'Fonnte Gateway Error: ' . ($result['reason'] ?? 'Gagal mengirim pesan.')
                    ];
                    $statusCode = 400;
                } else {
                    $responseData = [
                        'success' => true,
                        'message' => 'Kode OTP berhasil dikirim ke WhatsApp Anda!'
                    ];
                }
            } catch (\Exception $e) {
                $responseData = [
                    'success' => false,
                    'message' => 'Gagal mengirim WhatsApp OTP. Sistem error: ' . $e->getMessage()
                ];
                $statusCode = 500;
            }
        }

        return response()->json($responseData, $statusCode);
    }
}
