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

            {{-- Form menggunakan method POST dan tambahkan @method('PATCH') jika ini adalah route update --}}
            <form action="{{ route('superadmin.owner.updateStatus', $owner->owner_id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                @if ($errors->any())
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <ul class="text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Status Akun (Penting) --}}
                <div class="mb-6 p-4 bg-slate-50 rounded-xl border border-slate-200">
                    <label for="akun" class="block text-sm font-bold text-slate-700 mb-2">Status Verifikasi Akun</label>
                    <select id="akun" name="akun"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                        <option value="menunggu" {{ $owner->akun == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi
                        </option>
                        <option value="aktif" {{ $owner->akun == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $owner->akun == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900
                            {{ $user->register_method !== 'whatsapp' ? 'bg-slate-50 text-slate-500' : '' }}"
                            placeholder="Masukkan email">
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900
                            {{ $user->register_method === 'whatsapp' ? 'bg-slate-50 text-slate-500' : '' }}"
                            placeholder="Masukkan nomor WhatsApp">
                    </div>
                </div>

                <hr class="my-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                            <option value="Laki-laki" {{ ($owner->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ ($owner->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-bold text-slate-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $owner->tempat_lahir ?? '') }}"
                            class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                    </div>
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $owner->tanggal_lahir ?? '') }}"
                        class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                </div>

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer mt-6">
                    Update Data & Status Pemilik
                </button>
            </form>
        </div>
    </div>
@endsection
