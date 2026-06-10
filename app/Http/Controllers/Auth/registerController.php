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
            'name'     => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'otp'      => 'required|string|size:6',
        ];

        if ($method === 'google') {
            $rules['email'] = 'required|email|unique:users,email,NULL,user_id';
        } elseif ($method === 'whatsapp') {
            $rules['phone'] = 'required|numeric|unique:users,phone,NULL,user_id';

            if ($request->filled('email')) {
                $rules['email'] = 'nullable|email|unique:users,email,NULL,user_id';
            }
        } else {
            return back()->withErrors(['register_method' => 'Silahkan pilih metode pendaftaran terlebih dahulu.']);
        }

        $request->validate($rules, [
            'name.required'     => 'Nama lengkap wajib diisi.',
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

        // 🌟 DI SINI FORMAT 'user_id' OTOMATIS TERGENERATE LEWAT MODEL ELOQUENT
        User::create([
            'name'            => $request->input('name'),
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
     * Mengirimkan Kode OTP via Email atau WhatsApp
     */
    public function sendOtp(Request $request)
    {
        $method = $request->input('register_method');

        if ($method === 'google') {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,NULL,user_id'
            ], [
                'name.required'  => 'Nama lengkap wajib diisi sebelum mengirim OTP.',
                'email.required' => 'Email wajib diisi sebelum mengirim OTP.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email ini sudah terdaftar.'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|string|max:255',
                'phone' => 'required|numeric|unique:users,phone,NULL,user_id'
            ], [
                'name.required'  => 'Nama lengkap wajib diisi sebelum mengirim OTP.',
                'phone.required' => 'Nomor telepon wajib diisi sebelum mengirim OTP.',
                'phone.numeric'  => 'Nomor telepon harus berupa angka.',
                'phone.unique'   => 'Nomor telepon ini sudah terdaftar.'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $otpCode = (string) rand(100000, 999999);
        session(['generated_otp' => $otpCode]);

        $responseData = [];
        $statusCode = 200;

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
        } else { // 🌟 PERBAIKAN SINTAKS: Menambahkan kata kunci 'else' yang hilang agar tidak bertabrakan
            try {
                $phone = $request->input('phone');

                if (strpos($phone, '0') === 0) {
                    $phone = '62' . substr($phone, 1);
                }

                $messageTemplate = "*REKTOR KOST*\n\n" .
                    "Halo! Kode OTP pendaftaran akun Anda adalah: *{$otpCode}*\n\n" .
                    "Kode ini hanya berlaku selama 5 menit. Demi keamanan akun Anda, " .
                    "jangan sebarkan kode ini kepada siapa pun termasuk pihak Rektor Kost.";

                $response = Http::withHeaders([
                    'Authorization' => env('WA_GATEWAY_TOKEN'),
                ])->post('https://api.fonnte.com/send', [
                    'target'  => $phone,
                    'message' => $messageTemplate,
                ]);

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
