@extends('Auth.layouts.app')

@section('title', 'Masuk')

@section('content')
    <div class="w-full max-w-md bg-white border border-gray-100 rounded-2xl shadow-xs p-6 sm:p-8 space-y-6">

        <div class="flex border-b border-gray-200 text-sm font-bold">
            <a href="{{ route('login') }}" class="w-1/2 text-center pb-3 border-b-2 border-gray-900 text-gray-900 transition">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="w-1/2 text-center pb-3 text-gray-400 hover:text-gray-600 transition">
                Daftar
            </a>
        </div>

        <div class="text-center space-y-2">
            <h2 class="text-xl font-black text-gray-900 tracking-tight">Masuk Sebagai Pengguna</h2>
            <p class="text-xs text-gray-400 max-w-xs mx-auto">Temukan hunian aman dengan standar kualitas terjamin.</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-3 pt-2">
                <a href="/auth/google"
                    class="w-full border border-gray-300 bg-white hover:bg-gray-100 hover:border-gray-400 text-gray-700 text-xs font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2.5 transition duration-200 shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5.04c1.64 0 3.12.56 4.28 1.67l3.2-3.2C17.52 1.58 14.99 1 12 1 7.35 1 3.4 3.65 1.49 7.51l3.77 2.92C6.15 7.15 8.87 5.04 12 5.04z" />
                        <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.34H12v4.44h6.44c-.28 1.46-1.1 2.69-2.34 3.52l3.63 2.82c2.13-1.97 3.36-4.87 3.36-8.44z" />
                        <path fill="#FBBC05" d="M5.26 14.57c-.24-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29L1.49 7.07C.54 8.98 0 11.13 0 13.4s.54 4.42 1.49 6.33l3.77-2.93z" />
                        <path fill="#34A853" d="M12 23c3.24 0 5.97-1.08 7.96-2.92l-3.63-2.82c-1.01.68-2.3 1.08-3.96 1.08-3.13 0-5.85-2.11-6.74-5.39L1.86 15.9C3.77 19.79 7.72 23 12 23z" />
                    </svg>
                    Masuk dengan Google
                </a>

                <a href="/auth/whatsapp"
                    class="w-full bg-[#25D366] hover:bg-[#1ebd59] text-white text-xs font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2.5 transition duration-200 shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.713-1.455L0 24zm6.59-4.846c1.66.986 3.296 1.506 5.356 1.507 5.43 0 9.85-4.416 9.854-9.842.002-2.63-1.023-5.101-2.885-6.964C17.06 1.991 14.597.967 11.97.967c-5.415 0-9.819 4.404-9.823 9.832-.001 2.042.525 3.619 1.503 5.23L2.654 21.352l5.051-1.325z" />
                    </svg>
                    Masuk dengan WhatsApp
                </a>
            </div>

            <div class="relative flex py-2 items-center text-xs text-gray-400 justify-center">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 font-normal lowercase tracking-wider">atau</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-medium text-gray-700 block mb-1.5">Email atau No. Telepon</label>
                    <input type="text" name="login_identity" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" placeholder="Contoh: user@gmail.com atau 0812...">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-xs font-medium text-gray-700">Kata Sandi</label>
                        <a href="#" class="text-[11px] text-gray-500 hover:underline">Lupa sandi?</a>
                    </div>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" placeholder="Masukkan kata sandi Anda">
                </div>

                <button type="submit" class="w-full bg-[#071931] hover:bg-opacity-95 text-white text-xs font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-xs cursor-pointer">
                    Masuk Ke Akun
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-xs text-gray-500 font-medium">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-gray-900 font-bold hover:underline">Daftar sekarang</a>
            </p>
        </div>

        <div class="bg-amber-50/60 border-l-4 border-amber-400 p-4 rounded-r-xl">
            <p class="text-[11px] text-amber-700 font-medium leading-relaxed">
                "Daftar untuk simpan hunian favorit, booking jadwal survey instan, dan pantau status pengajuan kost Anda dengan mudah."
            </p>
        </div>

    </div>
@endsection
