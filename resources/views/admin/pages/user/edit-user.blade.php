@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('superadmin.user.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengguna
            </a>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Pengguna</h1>

            @if ($errors->any())
                <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-6">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.user.update', $user->user_id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">ID Pengguna</label>
                    <input type="text" value="{{ $user->user_id }}" readonly
                        class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                @if ($user->register_method === 'google')
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Email (Akun Google)</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                    </div>
                @endif

                @if ($user->register_method === 'whatsapp')
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Role</label>
                    <select name="role"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                        <option value="pengguna" {{ old('role', $user->role) == 'pengguna' ? 'selected' : '' }}>Pengguna
                        </option>
                        <option value="pemilik" {{ old('role', $user->role) == 'pemilik' ? 'selected' : '' }}>Pemilik
                        </option>
                        <option value="teknisi" {{ old('role', $user->role) == 'teknisi' ? 'selected' : '' }}>Teknisi
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Password Baru</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                    <p class="text-xs text-slate-400 mt-1">Min. 8 karakter jika diisi.</p>
                </div>

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer">
                    Perbarui Pengguna
                </button>
            </form>
        </div>
    </div>
@endsection
