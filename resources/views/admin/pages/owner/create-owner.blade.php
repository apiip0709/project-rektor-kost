@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('superadmin.owner.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Pemilik
            </a>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Lengkapi Data Pemilik</h1>

            <form action="{{ route('superadmin.owner.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->user_id }}">

                @if ($errors->any())
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <ul class="text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="user_id" class="block text-sm font-bold text-slate-700 mb-1">ID User</label>
                        <input type="text" id="user_id" value="{{ $user->user_id }}" readonly
                            class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" value="{{ $user->name }}" readonly
                            class="w-full p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">
                            Email {{ $user->register_method === 'whatsapp' ? '(Wajib Diisi)' : '' }}
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            {{ $user->register_method !== 'whatsapp' ? 'readonly' : 'required' }}
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900 {{ $user->register_method !== 'whatsapp' ? 'bg-slate-50 text-slate-500 cursor-not-allowed' : '' }}"
                            placeholder="Masukkan email">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-bold text-slate-700 mb-1">
                            Nomor WhatsApp {{ $user->register_method !== 'whatsapp' ? '(Wajib Diisi)' : '' }}
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            {{ $user->register_method === 'whatsapp' ? 'readonly' : 'required' }}
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900 {{ $user->register_method === 'whatsapp' ? 'bg-slate-50 text-slate-500 cursor-not-allowed' : '' }}"
                            placeholder="Masukkan nomor WhatsApp">
                    </div>
                </div>

                <hr class="my-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-bold text-slate-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            required
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                    </div>
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        required class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer mt-6">
                    Simpan Data Pemilik
                </button>
            </form>
        </div>
    </div>
@endsection
