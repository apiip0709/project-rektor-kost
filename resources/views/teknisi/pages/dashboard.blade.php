@extends('teknisi.layouts.teknisi')

@section('content')
    <div class="space-y-6 max-w-7xl mx-auto p-2 pb-12">

        <!-- Heading Dashboard Kinerja -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Dashboard Kinerja</h2>
            <p class="text-sm text-gray-500">Ringkasan aktivitas dan input properti terbaru[cite: 5].</p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Card 1: Input Hari Ini -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm relative">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Input Hari Ini</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">12</h3>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <span class="text-emerald-600 font-semibold">↗ +3</span> dari kemarin[cite: 5]
                        </p>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <i class="fa-regular fa-file-lines text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Properti -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm relative">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Properti</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">148</h3>
                        <p class="text-xs text-gray-500 mt-2">Total di platform[cite: 5]</p>
                    </div>
                    <div class="p-3 bg-sky-50 text-sky-500 rounded-xl">
                        <i class="fa-solid fa-building text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
