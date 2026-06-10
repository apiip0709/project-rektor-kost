@extends('admin.layouts.superadmin')

@section('content')
    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Registrasi</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan verifikasi pengguna dan pemilik properti yang terdaftar dalam
                ekosistem.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div
                class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/50">
                <h2 class="font-bold text-slate-800 text-lg">Pengguna Terdaftar</h2>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <form action="{{ route('superadmin.user.index') }}" method="GET" class="relative flex-1 sm:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="search" value="{{ $keyword }}"
                            placeholder="Cari pengguna atau email..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-4 text-sm text-slate-700 placeholder-slate-400 outline-none focus:border-slate-400 transition-all">
                    </form>

                    <button
                        class="flex items-center gap-2 rounded-xl bg-[#0F172A] px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition-colors cursor-pointer shadow-sm">
                        <i class="fa-solid fa-file-export text-xs"></i> Ekspor
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr
                            class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-400 text-center">
                            <th class="py-3.5 px-4 text-left w-28">ID Pengguna</th>
                            <th class="py-3.5 px-4 text-left">Nama Lengkap</th>
                            <th class="py-3.5 px-4 text-left">Email</th>
                            <th class="py-3.5 px-4">Nomor HP</th>
                            <th class="py-3.5 px-4">Tanggal Registrasi</th>
                            <th class="py-3.5 px-4 w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-colors text-center text-slate-700">
                                <td class="py-4 px-4 text-left font-semibold text-slate-400 text-xs">
                                    {{ $user->user_id }} </td>
                                <td class="py-4 px-4 text-left font-bold text-slate-900">
                                    {{ $user->name }}
                                </td>
                                <td class="py-4 px-4 text-left text-slate-500 font-medium">
                                    {{ $user->email }}
                                </td>
                                <td class="py-4 px-4 font-medium">
                                    {{ $user->phone ?? '' }}
                                </td>
                                <td class="py-4 px-4 text-slate-500 font-medium">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-col gap-1.5 justify-center items-center">
                                        <a href="#"
                                            class="w-full max-w-[80px] rounded-md bg-[#0F172A] py-1 text-center text-xs font-bold text-white hover:bg-slate-800 transition-colors cursor-pointer shadow-sm">
                                            Lihat
                                        </a>
                                        <a href="#"
                                            class="w-full max-w-[80px] rounded-md border border-amber-500 bg-white py-1 text-center text-xs font-bold text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                    <i class="fa-solid fa-user-slash text-3xl mb-3 block text-slate-300"></i>
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="p-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/30">
                <p class="text-xs font-semibold text-slate-500 text-center sm:text-left">
                    Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari
                    {{ $users->total() }} entri
                </p>

                <div class="flex justify-center">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>

        </div>
    </div>
@endsection
