@extends('admin.layouts.superadmin')

@section('content')
    <div class="p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Data Operasional Properti</h1>
            <p class="text-slate-500 text-sm">Kelola seluruh listing properti kost di platform Rektor-Kost.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            @php
                $stats = [
                    ['label' => 'Total Properti', 'value' => '1,248', 'icon' => 'fa-house'],
                    [
                        'label' => 'Aktif & Verifikasi',
                        'value' => '1,102',
                        'icon' => 'fa-circle-check',
                        'color' => 'text-emerald-500',
                    ],
                    ['label' => 'Langganan Premium', 'value' => '156', 'icon' => 'fa-star', 'color' => 'text-blue-500'],
                    ['label' => 'Langganan Gold', 'value' => '312', 'icon' => 'fa-medal', 'color' => 'text-amber-500'],
                    [
                        'label' => 'Langganan Silver',
                        'value' => '780',
                        'icon' => 'fa-circle',
                        'color' => 'text-slate-400',
                    ],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-slate-400 text-xs font-bold uppercase">{{ $stat['label'] }}</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $stat['value'] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Toolbar --}}
        <div class="flex justify-between items-center mb-4">
            <div class="text-sm text-slate-600">Tampilkan <select class="border rounded p-1 mx-1">
                    <option>25</option>
                </select> entri</div>
            <div class="flex gap-2">
                <button class="px-4 py-2 border rounded-lg text-sm font-semibold hover:bg-slate-50"><i
                        class="fa-solid fa-filter mr-2"></i>Filter</button>
                <button class="px-4 py-2 border rounded-lg text-sm font-semibold hover:bg-slate-50"><i
                        class="fa-solid fa-file-csv mr-2"></i>Ekspor CSV</button>
                <button class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800"><i
                        class="fa-solid fa-plus mr-2"></i>Tambah Manual</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-xs">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Info Properti</th>
                        <th class="p-4">Langganan</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($kosts as $kost)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-mono text-slate-500">{{ $kost->id_kost }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-200 rounded-lg"></div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $kost->name_kost }}</p>
                                        <p class="text-xs text-slate-500">{{ count($kost->rooms ?? []) }} Kamar •
                                            {{ $kost->gender_type ?? 'Campur' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4"><span
                                    class="px-2 py-1 rounded bg-slate-100 text-xs font-bold">{{ strtoupper($kost->status_langganan ?? 'Silver') }}</span>
                            </td>
                            <td class="p-4 text-slate-600">{{ $kost->city }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-2 h-2 rounded-full {{ $kost->status_kemitraan == 'aktif' ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                    <span class="text-slate-600">{{ ucfirst($kost->status_kemitraan) }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <button class="px-3 py-1 border rounded text-xs font-bold hover:bg-slate-100">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
