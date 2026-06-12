@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header navigasi --}}
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('superadmin.owner.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Pemilik
            </a>
            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                <i class="fa-solid fa-link mr-1"></i> Data Berasosiasi
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Card Data User --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative">
                <div class="flex items-center gap-2 mb-4 border-b pb-2">
                    <i class="fa-solid fa-user text-slate-400"></i>
                    <h2 class="text-lg font-bold text-slate-900">Informasi Akun (User)</h2>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">ID User</p>
                        <p class="text-slate-800 font-medium">{{ $owner->user->user_id }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</p>
                        <p class="text-slate-800 font-medium">{{ $owner->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email</p>
                        <p class="text-slate-800 font-medium">{{ $owner->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Phone</p>
                        <p class="text-slate-800 font-medium">{{ $owner->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Role</p>
                        <p class="text-slate-800 font-medium capitalize">{{ $owner->user->role }}</p>
                    </div>
                </div>
            </div>

            {{-- Card Data Owner --}}
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative">
                <div class="flex items-center gap-2 mb-4 border-b pb-2">
                    <i class="fa-solid fa-id-card text-slate-400"></i>
                    <h2 class="text-lg font-bold text-slate-900">Informasi Pemilik (Owner)</h2>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">ID Owner</p>
                        <p class="text-slate-800 font-mono text-sm">{{ $owner->owner_id }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Gender</p>
                        <p class="text-slate-800 font-medium">{{ $owner->gender }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tempat, Tanggal Lahir</p>
                        <p class="text-slate-800 font-medium">{{ $owner->pob }},
                            {{ $owner->dob ? \Carbon\Carbon::parse($owner->dob)->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Akun</p>
                        <div class="mt-1">
                            <span
                                class="px-2 py-1 text-[10px] font-bold rounded-lg {{ $owner->akun == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ strtoupper($owner->akun) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Langganan</p>
                        <div class="mt-1">
                            <span
                                class="px-2 py-1 text-[10px] font-bold rounded-lg
                            {{ $owner->status == 'premium'
                                ? 'bg-purple-100 text-purple-700'
                                : ($owner->status == 'gold'
                                    ? 'bg-amber-100 text-amber-700'
                                    : 'bg-slate-100 text-slate-600') }}">
                                {{ strtoupper($owner->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
