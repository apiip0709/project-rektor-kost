@extends('Auth.layouts.app')

@section('title', 'Daftar')

@section('content')
    <div class="w-full max-w-md bg-white border border-gray-100 rounded-2xl shadow-xs p-6 sm:p-8 space-y-6">

        <div class="flex border-b border-gray-200 text-sm font-bold">
            <a href="{{ route('login') }}" class="w-1/2 text-center pb-3 text-gray-400 hover:text-gray-600 transition">
                Masuk
            </a>
            <a href="{{ route('register') }}"
                class="w-1/2 text-center pb-3 border-b-2 border-gray-900 text-gray-900 transition">
                Daftar
            </a>
        </div>

        <div class="text-center space-y-2">
            <h2 class="text-xl font-black text-gray-900 tracking-tight">Daftar Sebagai Pengguna</h2>
            <p class="text-xs text-gray-400 max-w-xs mx-auto">Mulai cari kost impianmu dan nikmati berbagai kemudahan.</p>
        </div>

        <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="register_method" id="register_method" value="{{ old('register_method') }}">

            @error('register_method')
                <p class="text-xs text-red-500 font-semibold mb-2">{{ $message }}</p>
            @enderror

            <div id="area_tombol_utama" class="space-y-4">
                <button type="button" id="btn_google" onclick="selectMethod('google')"
                    class="w-full border border-gray-300 bg-white hover:bg-gray-100 hover:border-gray-400 text-gray-700 text-xs font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2.5 transition duration-200 shadow-2xs cursor-pointer">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4" alt="Google">
                    Daftar dengan Google
                </button>

                <button type="button" id="btn_whatsapp" onclick="selectMethod('whatsapp')"
                    class="w-full bg-[#25D366] hover:bg-[#1ebd59] text-white text-xs font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2.5 transition duration-200 shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.713-1.455L0 24zm6.59-4.846c1.66.986 3.296 1.506 5.356 1.507 5.43 0 9.85-4.416 9.854-9.842.002-2.63-1.023-5.101-2.885-6.964C17.06 1.991 14.597.967 11.97.967c-5.415 0-9.819 4.404-9.823 9.832-.001 2.042.525 3.619 1.503 5.23L2.654 21.352l5.051-1.325z" />
                    </svg>
                    Daftar dengan WhatsApp
                </button>
            </div>

            <div id="pembatas_atau" class="relative flex py-2 items-center text-xs text-gray-400 justify-center hidden">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 font-bold tracking-wider">ATAU</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <div id="area_input_dinamis" class="space-y-4">

                <div id="kolom_google" class="hidden">
                    <label class="text-xs font-bold text-gray-700 block mb-1.5">No. Telepon</label>
                    <input type="text" name="phone" id="input_phone" value="{{ old('phone') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition"
                        placeholder="Contoh: 0812...">
                    @error('phone')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div id="kolom_whatsapp" class="hidden">
                    <label class="text-xs font-bold text-gray-700 block mb-1.5">Email</label>
                    <input type="email" name="email" id="input_email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition"
                        placeholder="Contoh: user@gmail.com">
                    @error('email')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div id="input_bersama" class="space-y-4 hidden">
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1.5">Kata Sandi</label>
                        <div class="flex gap-2">
                            <input type="password" name="password" id="input_password"
                                class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition"
                                placeholder="*********">
                            <button type="button" id="btn_send_otp" onclick="sendOtp()"
                                class="bg-[#ffcb42] hover:bg-[#e6b63b] text-gray-950 text-xs font-bold px-4 py-2.5 rounded-xl transition cursor-pointer whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                                Kirim OTP
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1.5">Kode OTP</label>
                        <input type="text" name="otp" value="{{ old('otp') }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition"
                            placeholder="Masukkan 6 digit kode">
                        @error('otp')
                            <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror

                        <p id="notif_otp_sukses" class="hidden mt-1.5 text-[11px] font-semibold flex items-center gap-1">
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#071931] hover:bg-opacity-95 text-white text-xs font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-xs cursor-pointer">
                        Daftar Sekarang
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center">
            <p class="text-xs text-gray-500 font-medium">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-gray-900 font-bold hover:underline">Masuk
                    sekarang</a>
            </p>
        </div>

        <div class="bg-amber-50/60 border-l-4 border-amber-400 p-4 rounded-r-xl">
            <p class="text-[11px] text-amber-700 font-medium leading-relaxed">
                "Daftar untuk simpan hunian favorit, booking jadwal survey instan, dan pantau status pengajuan kost Anda
                dengan mudah."
            </p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentMethod = document.getElementById('register_method').value;
            if (currentMethod) {
                selectMethod(currentMethod);

                if (document.getElementsByName('otp')[0].value || "{{ $errors->has('otp') }}") {
                    showOtpMessage('success', 'Sesi registrasi dimuat kembali.');
                }
            }
        });

        function selectMethod(method) {
            document.getElementById('register_method').value = method;
            document.getElementById('input_bersama').classList.remove('hidden');

            if (method === 'google') {
                // Sembunyikan tombol utama, tampilkan tombol alternatif di bawah teks "ATAU"
                document.getElementById('btn_google').classList.add('hidden');
                document.getElementById('btn_whatsapp').classList.remove('hidden');
                document.getElementById('pembatas_atau').classList.remove('hidden');

                // SINKRONISASI: Jika pilih Google, buka kolom Email (Gmail)
                document.getElementById('kolom_whatsapp').classList.remove('hidden');
                document.getElementById('kolom_google').classList.add('hidden');

            } else if (method === 'whatsapp') {
                // Sembunyikan tombol utama, tampilkan tombol alternatif di bawah teks "ATAU"
                document.getElementById('btn_whatsapp').classList.add('hidden');
                document.getElementById('btn_google').classList.remove('hidden');
                document.getElementById('pembatas_atau').classList.remove('hidden');

                // SINKRONISASI: Jika pilih WhatsApp, buka kolom No. Telepon
                document.getElementById('kolom_google').classList.remove('hidden');
                document.getElementById('kolom_whatsapp').classList.add('hidden');
            }

            // Bersihkan notifikasi pesan lama saat berganti metode
            document.getElementById('notif_otp_sukses').classList.add('hidden');
        }

        function showOtpMessage(type, message) {
            const targetNotif = document.getElementById('notif_otp_sukses');

            if (type === 'success') {
                targetNotif.className = "mt-1.5 text-[11px] font-semibold text-emerald-600 flex items-center gap-1";
                targetNotif.innerHTML = `
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
                <span>${message}</span>`;
            } else {
                targetNotif.className = "mt-1.5 text-[11px] font-semibold text-red-500 flex items-center gap-1";
                targetNotif.innerHTML = `
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"></path>
                </svg>
                <span>${message}</span>`;
            }
            targetNotif.classList.remove('hidden');
        }

        function sendOtp() {
            const method = document.getElementById('register_method').value;
            const password = document.getElementById('input_password').value;
            const email = document.getElementById('input_email').value;
            const phone = document.getElementById('input_phone').value;
            const btnSend = document.getElementById('btn_send_otp');

            if (!method) {
                alert('Silahkan klik salah satu metode pendaftaran di atas terlebih dahulu.');
                return;
            }

            // SINKRONISASI VALIDASI: Menyesuaikan aturan pengecekan variabel dengan input form
            if (method === 'google' && !email) {
                showOtpMessage('error', 'Masukkan alamat email Gmail Anda terlebih dahulu!');
                return;
            }
            if (method === 'whatsapp' && !phone) {
                showOtpMessage('error', 'Masukkan nomor telepon WhatsApp Anda terlebih dahulu!');
                return;
            }
            if (!password || password.length < 8) {
                showOtpMessage('error', 'Kata sandi wajib diisi dan minimal 8 karakter!');
                return;
            }

            btnSend.disabled = true;
            btnSend.innerText = 'Mengirim...';

            fetch("{{ route('register.otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        register_method: method,
                        email: email,
                        phone: phone,
                        password: password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    btnSend.disabled = false;
                    btnSend.innerText = 'Kirim OTP';

                    if (data.success) {
                        showOtpMessage('success', data.message);
                    } else {
                        showOtpMessage('error', data.message);
                    }
                })
                .catch(error => {
                    btnSend.disabled = false;
                    btnSend.innerText = 'Kirim OTP';
                    showOtpMessage('error', 'Terjadi kesalahan sistem server. Coba beberapa saat lagi.');
                });
        }
    </script>
@endsection
