@extends('admin.layouts.superadmin')

@section('content')
    <div class="space-y-6">

        @if (session('success'))
            <div id="success-alert"
                class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm flex justify-between items-center animate-in fade-in slide-in-from-top-2 duration-300">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('success-alert').remove()"
                    class="text-emerald-600 hover:text-emerald-800 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Registrasi</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan verifikasi pengguna.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div
                class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/50">
                <h2 class="font-bold text-slate-800 text-lg">Pengguna Terdaftar</h2>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" id="search-input" value="{{ $keyword ?? '' }}"
                            placeholder="Cari ID, Nama, Email, HP..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-4 text-sm outline-none focus:border-slate-400 transition-all">
                    </div>

                    <a href="{{ route('superadmin.user.create') }}"
                        class="flex items-center gap-2 rounded-xl bg-[#0F172A] px-4 py-2 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-sm whitespace-nowrap">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Tambah Akun
                    </a>
                </div>
            </div>

            <div id="tabel-container">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr
                                class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-400 text-center">
                                <th class="py-3.5 px-4 text-left">ID Pengguna</th>
                                <th class="py-3.5 px-4 text-left">Nama</th>
                                <th class="py-3.5 px-4 text-left">Role</th>
                                <th class="py-3.5 px-4 text-left">Email/HP</th>
                                <th class="py-3.5 px-4">Tanggal</th>
                                <th class="py-3.5 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($users as $user)
                                <tr class="hover:bg-slate-50 text-center text-slate-700">
                                    <td class="py-4 px-4 text-left text-xs font-mono text-slate-500">{{ $user->user_id }}
                                    </td>
                                    <td class="py-4 px-4 text-left font-bold text-slate-900">{{ $user->name }}</td>
                                    <td class="py-4 px-4 text-left capitalize">{{ $user->role }}</td>
                                    <td class="py-4 px-4 text-left">
                                        <div class="text-slate-900">{{ $user->email ?? $user->phone }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-wider">
                                            {{ $user->register_method }}</div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-900">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-4">
                                        <a href="{{ route('superadmin.user.edit', $user->user_id) }}"
                                            class="inline-block px-4 py-1.5 rounded-lg border border-amber-500 text-amber-600 hover:bg-amber-50 transition-colors font-bold text-xs">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-remove success message
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) alert.remove();
        }, 5000);

        const searchInput = document.getElementById('search-input');
        const container = document.getElementById('tabel-container');
        let debounceTimer;

        searchInput.addEventListener('keyup', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('superadmin.user.index') }}?search=${encodeURIComponent(this.value)}`)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('tabel-container');
                        if (newContent) {
                            container.innerHTML = newContent.innerHTML;
                        }
                    });
            }, 300);
        });
    </script>
@endsection
