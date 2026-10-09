@extends('teknisi.layouts.teknisi')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                                            {{ $kost->klasifikasi }}</p>
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
                                    <a href="{{ route('teknisi.kost.show', $kost->kost_id) }}"
                                        class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teknisi.kost.edit', $kost->kost_id) }}"
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
@endsection
