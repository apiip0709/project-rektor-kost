@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto mt-10">
        <div class="mb-4">
            <a href="{{ route('superadmin.user.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengguna
            </a>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Tambah Pengguna Baru</h1>

            <div id="step-1" class="space-y-4">
                <p class="text-slate-600 mb-4">Pilih metode pendaftaran:</p>
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

            <form id="step-2" action="{{ route('superadmin.user.store') }}" method="POST"
                class="{{ $errors->any() ? '' : 'hidden' }} space-y-4">
                @csrf
                <input type="hidden" name="register_method" id="register_method" value="{{ old('register_method') }}">

                <button type="button" onclick="resetForm()"
                    class="text-sm text-slate-400 hover:text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Ganti Metode
                </button>

                @if ($errors->any())
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <ul class="text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Role</label>
                    <select name="role"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                        <option value="pengguna" {{ old('role') == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                        <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                        <option value="teknisi" {{ old('role') == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                    </select>
                </div>

                <div id="email-field" class="{{ old('register_method') == 'google' ? '' : 'hidden' }}">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                <div id="phone-field" class="{{ old('register_method') == 'whatsapp' ? '' : 'hidden' }}">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer">
                    Simpan Pengguna
                </button>
            </form>
        </div>
    </div>

    <script>
        function selectMethod(method) {
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            document.getElementById('register_method').value = method;

            if (method === 'google') {
                document.getElementById('email-field').classList.remove('hidden');
                document.getElementById('phone-field').classList.add('hidden');
            } else {
                document.getElementById('email-field').classList.add('hidden');
                document.getElementById('phone-field').classList.remove('hidden');
            }
        }

        function resetForm() {
            document.getElementById('step-1').classList.remove('hidden');
            document.getElementById('step-2').classList.add('hidden');
        }
    </script>
@endsection
