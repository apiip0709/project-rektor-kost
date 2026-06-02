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
        // 1. Tentukan validasi berdasarkan metode yang dipilih
        $method = $request->input('register_method'); // 'google' atau 'whatsapp'

        $rules = [
            'password' => 'required|string|min:8',
            'otp'      => 'required|string|size:6',
        ];

        if ($method === 'google') {
            $rules['phone'] = 'required|numeric|unique:users,phone';
        } elseif ($method === 'whatsapp') {
            $rules['email'] = 'required|email|unique:users,email';
        } else {
            return back()->withErrors(['register_method' => 'Silahkan pilih metode pendaftaran terlebih dahulu.']);
        }

        // 2. Jalankan Validasi dengan Pesan Error Bahasa Indonesia
        $request->validate($rules, [
            'phone.required'    => 'Nomor telepon wajib diisi.',
            'phone.numeric'     => 'Nomor telepon harus berupa angka.',
            'phone.unique'      => 'Nomor telepon ini sudah terdaftar.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'otp.required'      => 'Kode OTP wajib diisi.',
            'otp.size'          => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        // 2.5 VALIDASI OTP DARI SESSION
        // Mengambil kode OTP yang sebelumnya disimpan di session saat tombol "Kirim OTP" diklik
        $sessionOtp = session('generated_otp');
        
        if (!$sessionOtp || $request->input('otp') !== $sessionOtp) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah atau telah kedaluwarsa.'])->withInput();
        }

        // 3. Simpan Data ke Database (Tabel Users) jika OTP Benar
        $user = User::create([
            'email'           => $request->input('email'),
            'phone'           => $request->input('phone'),
            'password'        => Hash::make($request->input('password')),
            'register_method' => $method,
            'role'            => 'pencari',
        ]);

        // Hapus OTP dari session setelah sukses digunakan agar tidak bisa dipakai ulang
        session()->forget('generated_otp');

        // 4. Otomatis Login setelah Berhasil Daftar
        Auth::login($user);

        // 5. Alihkan ke halaman utama / dashboard aplikasi
        return redirect('/dashboard')->with('success', 'Akun Anda berhasil didaftarkan!');
    }

    /**
     * Handle Request AJAX / Interaksi tombol untuk Kirim OTP (Penunjang)
     */
    public function sendOtp(Request $request)
    {
        $method = $request->input('register_method');

        // 1. Validasi input identitas sebelum mengirim OTP agar tidak sia-sia
        if ($method === 'whatsapp') {
            // Jika daftar lewat WA, input dinamis yang muncul adalah Email
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email'
            ], [
                'email.required' => 'Email wajib diisi sebelum mengirim OTP.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email ini sudah terdaftar.'
            ]);
        } else {
            // Jika daftar lewat Google, input dinamis yang muncul adalah No Telepon
            $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric|unique:users,phone'
            ], [
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

        // 2. Generate 6 digit angka acak
        $otpCode = (string) rand(100000, 999999);

        // 3. Simpan ke session aplikasi agar bisa dicek saat submit register nanti
        session(['generated_otp' => $otpCode]);

        // 4. Eksekusi pengiriman berdasarkan metode
        if ($method === 'whatsapp') {
            try {
                // Kirim OTP live ke Gmail asli user menggunakan Mailable SendOtpMail
                Mail::to($request->input('email'))->send(new SendOtpMail($otpCode));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Kode OTP berhasil dikirim ke email Anda!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim email. Pastikan pengaturan SMTP .env sudah benar.'
                ], 500);
            }
        } else {
            Http::withHeaders(['Authorization' => 'TOKEN'])->post('URL', ['target' => $request->phone, 'message' => $otpCode]);

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim melalui SMS/WhatsApp ke nomor telepon Anda!'
            ]);
        }
    }
}
