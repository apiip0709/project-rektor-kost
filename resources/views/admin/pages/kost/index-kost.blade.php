@extends('admin.layouts.superadmin')

@section('content')
    <div class="flex flex-col gap-6">
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

        <div class="mb-2">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Data Operasional Properti</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola seluruh listing properti kost di platform Rektor-Kost.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach ([['Total Properti', $stats['total'], 'fa-house', 'text-slate-900'], ['Aktif & Terverifikasi', $stats['aktif'], 'fa-circle-check', 'text-emerald-500'], ['Langganan Premium', $stats['premium'], 'fa-star', 'text-blue-500'], ['Langganan Gold', $stats['gold'], 'fa-medal', 'text-amber-500'], ['Langganan Silver', $stats['silver'], 'fa-circle', 'text-slate-400']] as $stat)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $stat[0] }}</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stat[1] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Table Section --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    Tampilkan
                    <select class="border border-slate-200 rounded-lg p-1 outline-none">
                        <option>25</option>
                    </select>
                    entri
                </div>
                <div class="flex gap-2">
                    <div class="relative w-48">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" id="search-input" value="{{ $keyword ?? '' }}" placeholder="Cari ID, Kost..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-4 text-sm outline-none focus:border-slate-400 transition-all">
                    </div>
                    <button type="button" onclick="filterModal.showModal()"
                        class="px-4 py-2 border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition cursor-pointer">
                        <i class="fa-solid fa-filter mr-2"></i>Filter
                    </button>
                    <button type="button" onclick="ownerModal.showModal()"
                        class="flex items-center gap-2 rounded-xl bg-[#0F172A] px-4 py-2 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-sm whitespace-nowrap cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i> Tambah Manual
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="main-table" class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-400 text-xs font-bold uppercase">
                        <tr>
                            <th class="py-3 px-4 text-left">ID</th>
                            <th class="py-3 px-4 text-left">Info Properti</th>
                            <th class="py-3 px-4 text-left">Langganan</th>
                            <th class="py-3 px-4 text-left">Lokasi</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="divide-y divide-slate-100">
                        @foreach ($kosts as $kost)
                            <tr class="hover:bg-slate-50">
                                <td class="py-4 px-4 font-mono text-xs text-slate-500">{{ $kost->kost_id }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 overflow-hidden">
                                            @if (isset($kost->images[0]))
                                                <img src="{{ asset('storage/' . $kost->images[0]) }}"
                                                    alt="{{ $kost->name_kost }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-image"></i>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="font-bold text-slate-900">{{ $kost->name_kost }}</p>
                                            <p class="text-[10px] text-slate-500">{{ count($kost->rooms ?? []) }} Kamar •
                                                {{ $kost->gender_type ?? 'Campur' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-2 py-1 text-[10px] font-bold rounded-lg bg-slate-100 uppercase">{{ $kost->status_langganan }}</span>
                                </td>
                                <td class="py-4 px-4 text-slate-600">{{ $kost->city }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="w-2 h-2 rounded-full {{ $kost->status_kemitraan == 'aktif' ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                        <span class="text-slate-600">{{ ucfirst($kost->status_kemitraan) }}</span>
                                    </div>
                                </td>
                                {{-- Ubah bagian ini --}}
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('superadmin.kost.show', $kost->kost_id) }}"
                                            class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.kost.edit', $kost->kost_id) }}"
                                            class="text-amber-600 hover:text-amber-800 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Pilihan Owner --}}
    <dialog id="ownerModal" class="p-0 rounded-2xl shadow-xl w-full max-w-lg backdrop:bg-slate-900/50 fixed inset-0 m-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg">Pilih Owner</h3>
                <button onclick="ownerModal.close()" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            {{-- Opsi Tanpa Owner --}}
            <a href="{{ route('superadmin.kost.create') }}"
                class="block w-full p-4 mb-4 border-2 border-dashed border-slate-300 rounded-xl text-center text-sm font-bold text-slate-600 hover:border-slate-400 hover:bg-slate-50 transition">
                <i class="fa-solid fa-user-slash mr-2"></i> Tambah Tanpa Owner (Draft)
            </a>

            <input type="text" id="search-owner-modal" placeholder="Cari ID atau Nama Owner..."
                class="w-full rounded-xl border border-slate-200 py-2 px-4 text-sm mb-4 outline-none focus:border-slate-400">

            <div id="owner-list" class="max-h-80 overflow-y-auto space-y-2 pr-2">
                @foreach ($owners as $owner)
                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl hover:bg-slate-50 transition-colors"
                        data-name="{{ strtolower($owner->user->name) }}" data-id="{{ strtolower($owner->owner_id) }}"
                        data-email="{{ strtolower($owner->user->email) }}">

                        <div class="flex flex-col gap-0.5">
                            <div class="flex justify-between items-center">
                                <p class="font-bold text-sm text-slate-800">{{ $owner->user->name }}</p>
                                <span
                                    class="text-[10px] font-mono bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-bold">
                                    {{ $owner->owner_id }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">{{ $owner->user->email }}</span>
                            </div>
                        </div>

                        <a href="{{ route('superadmin.kost.create', ['owner_id' => $owner->owner_id]) }}"
                            class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg hover:bg-blue-700 transition-all cursor-pointer">
                            Pilih
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </dialog>

    {{-- Modal Filter --}}
    <dialog id="filterModal"
        class="p-0 rounded-2xl shadow-xl w-full max-w-sm backdrop:bg-slate-900/50 fixed inset-0 m-auto">
        <form method="GET" action="{{ route('superadmin.kost.index') }}" class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg">Filter Properti</h3>
                <button type="button" onclick="filterModal.close()"
                    class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="space-y-4">
                {{-- Tipe Langganan --}}
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase mb-2">Tipe Langganan</p>
                    <div class="space-y-2">
                        @foreach (['Premium', 'Gold', 'Silver'] as $tipe)
                            {{-- Menggunakan label dengan for agar terikat ke checkbox --}}
                            <label for="tipe_{{ strtolower($tipe) }}"
                                class="flex items-center gap-2 text-sm cursor-pointer hover:text-slate-900 transition">
                                <input type="checkbox" id="tipe_{{ strtolower($tipe) }}" name="langganan[]"
                                    value="{{ strtolower($tipe) }}" class="rounded border-slate-300 cursor-pointer">
                                {{ $tipe }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-slate-500 uppercase mb-2">Lokasi</label>
                    <select id="lokasi" name="lokasi"
                        class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm cursor-pointer outline-none focus:border-slate-400">
                        <option value="">Semua Lokasi</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" {{ request('lokasi') == $city ? 'selected' : '' }}>
                                {{ ucfirst($city) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-500 uppercase mb-2">Status
                        Properti</label>
                    <select id="status" name="status"
                        class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm cursor-pointer outline-none focus:border-slate-400">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex gap-2">
                <button type="button" onclick="filterModal.close()"
                    class="flex-1 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-xl cursor-pointer transition">Batal</button>
                <button type="submit"
                    class="flex-1 py-2 text-sm font-bold text-white bg-[#0F172A] rounded-xl cursor-pointer hover:bg-slate-800 transition">Terapkan</button>
            </div>
        </form>
    </dialog>

    <script>
        let debounceTimer;
        document.getElementById('search-input').addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const keyword = this.value;
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('superadmin.kost.index') }}?search=${encodeURIComponent(keyword)}`)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newBody = doc.getElementById('table-body');
                        if (newBody) {
                            document.getElementById('table-body').innerHTML = newBody.innerHTML;
                        }
                    });
            }, 300);
        });

        // Search Filter Modal Owner
        document.getElementById('search-owner-modal').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();

            document.querySelectorAll('#owner-list > div').forEach(item => {
                let name = item.getAttribute('data-name');
                let id = item.getAttribute('data-id');
                let email = item.getAttribute('data-email');

                // Cek apakah filter cocok dengan nama ATAU ID ATAU email
                if (name.includes(filter) || id.includes(filter) || email.includes(filter)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection
