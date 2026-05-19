@php
    // DATA DUMMY (Pengganti Database Sementara agar langsung tampil)
    $daftarKost = [
        (object) [
            'id' => 1,
            'nama' => 'Kost Eksklusif Bintang',
            'tipe' => 'Putra',
            'jarak' => 450,
            'titik_acuan' => 'Pintu 1 Unhas',
            'is_verified' => false,
            'fasilitas' => ['AC', 'WIFI', 'KMD DALAM'],
            'harga_bulanan' => 1500000,
            'harga_tahunan' => 17000000,
            'foto' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=500&q=80',
        ],
        (object) [
            'id' => 2,
            'nama' => 'Griya Mahasiswa Unhas',
            'tipe' => 'Campur',
            'jarak' => 900,
            'titik_acuan' => 'Pintu 1 Unhas',
            'is_verified' => false,
            'fasilitas' => ['AC', 'DAPUR'],
            'harga_bulanan' => 1200000,
            'harga_tahunan' => 13500000,
            'foto' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=500&q=80',
        ],
        (object) [
            'id' => 3,
            'nama' => 'Kost Putri Mawar Merah',
            'tipe' => 'Putri',
            'jarak' => 1200,
            'titik_acuan' => 'Pintu 1 Unhas',
            'is_verified' => false,
            'fasilitas' => ['WIFI', 'KMD DALAM'],
            'harga_bulanan' => 900000,
            'harga_tahunan' => 10000000,
            'foto' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=500&q=80',
        ],
        (object) [
            'id' => 4,
            'nama' => 'Wisma Tamalanrea',
            'tipe' => 'Putra',
            'jarak' => 600,
            'titik_acuan' => 'Pintu 1 Unhas',
            'is_verified' => true,
            'fasilitas' => ['AC', 'WIFI', 'DAPUR'],
            'harga_bulanan' => 1100000,
            'harga_tahunan' => 12000000,
            'foto' => 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?auto=format&fit=crop&w=500&q=80',
        ],
        (object) [
            'id' => 5,
            'nama' => 'Kost Asri Perintis',
            'tipe' => 'Campur',
            'jarak' => 900,
            'titik_acuan' => 'Pintu 1 Unhas',
            'is_verified' => false,
            'fasilitas' => ['WIFI', 'KMD DALAM'],
            'harga_bulanan' => 850000,
            'harga_tahunan' => 9500000,
            'foto' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=500&q=80',
        ],
    ];
@endphp

@extends('visitor.layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-black text-primary">Cari Kost</h1>
            <p class="text-xs text-gray-500 mt-1">Radius: <span class="font-semibold text-neutral">Sekitar Pintu 1 Unhas
                    (2km)</span></p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <button
                    class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-full border border-primary flex items-center gap-1 shadow-sm">
                    🚹 Putra
                </button>
                <button
                    class="bg-white text-neutral hover:bg-gray-50 text-xs font-bold px-4 py-2 rounded-full border border-gray-200">
                    🚺 Putri
                </button>
                <button
                    class="bg-white text-neutral hover:bg-gray-50 text-xs font-bold px-4 py-2 rounded-full border border-gray-200">
                    🚻 Campur
                </button>
            </div>

            <button
                class="bg-white text-neutral hover:bg-gray-50 text-xs font-bold px-4 py-2 rounded-lg border border-gray-200 flex items-center gap-1">
                🎛️ Filter
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach ($daftarKost as $kost)
            @include('visitor.components.card-kost', ['kost' => $kost])
        @endforeach
    </div>
@endsection
