@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('superadmin.owner.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pemilik
            </a>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Data Pemilik</h1>

            @if ($errors->any())
                <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-6">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.owner.update', $owner->owner_id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @if ($owner)
                    <div class="space-y-4">
                        <h2 class="text-sm font-black text-slate-400 uppercase tracking-wider border-b pb-2">
                            Informasi Pemilik (Owner)
                        </h2>

                        {{-- Gender --}}
                        <div>
                            <label for="gender" class="block text-sm font-bold text-slate-700 mb-1">Gender</label>
                            <select id="gender" name="gender"
                                class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                                <option value="Laki-laki"
                                    {{ old('gender', $owner->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('gender', $owner->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        <div>
                            <span class="block text-sm font-bold text-slate-700 mb-1">Tempat, Tanggal Lahir</span>
                            <div class="flex gap-2">
                                <input type="text" id="pob" name="pob" placeholder="Tempat Lahir"
                                    value="{{ old('pob', $owner->pob) }}" aria-label="Tempat Lahir"
                                    class="w-1/2 p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">

                                <input type="date" id="dob" name="dob" value="{{ old('dob', $owner->dob) }}"
                                    aria-label="Tanggal Lahir"
                                    class="w-1/2 p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-bold text-slate-700 mb-1">Status Akun</label>
                            <select id="status" name="status"
                                class="w-full p-3 border border-slate-200 rounded-lg outline-none focus:border-slate-900">

                                <option value="berlangganan"
                                    {{ old('status', $owner->status) == 'berlangganan' ? 'selected' : '' }}>
                                    Berlangganan
                                </option>

                                <option value="trial" {{ old('status', $owner->status) == 'trial' ? 'selected' : '' }}>
                                    Trial
                                </option>

                                <option value="tidak" {{ old('status', $owner->status) == 'tidak' ? 'selected' : '' }}>
                                    Tidak
                                </option>

                            </select>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-amber-50 text-amber-700 rounded-lg">
                        Data pemilik tidak ditemukan.
                    </div>
                @endif

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer">
                    Perbarui Data Pemilik
                </button>
            </form>
        </div>
    </div>
@endsection
