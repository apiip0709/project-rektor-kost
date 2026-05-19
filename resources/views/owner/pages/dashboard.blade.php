@extends('owner.layouts.admin')

@section('content')
    <div class="space-y-6 max-w-7xl mx-auto p-2 pb-12">

        <div
            class="bg-primary/10 p-6 rounded-2xl border border-gray-100 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Dashboard Pemilik Kost</h1>
                <p class="text-xs text-gray-500 mt-1">Pusat Kendali Kost dan Analisis Hunian Rektor-Kost (Akses Pemilik)</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="/kelola-kamar"
                    class="inline-flex items-center justify-center gap-2 bg-primary text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-opacity-95 transition-all shadow-xs hover:shadow-md transform hover:-translate-y-0.5 cursor-pointer">
                    <span>⚙️</span> Kelola Kamar Kost
                </a>
                <a href="/tambah-kamar"
                    class="inline-flex items-center justify-center gap-2 bg-primary text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-opacity-95 transition-all shadow-xs hover:shadow-md transform hover:-translate-y-0.5 cursor-pointer">
                    <span>➕</span> Tambahkan Kamar Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden flex flex-col group hover:shadow-md transition duration-200">
                        <div class="h-40 bg-gray-100 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=400&q=80"
                                 alt="Sampul Kost"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-xs">Aktif</span>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-primary transition">Kost Mahasiswa Mawar Biru</h3>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    📍 Jl. Perintis Kemerdekaan KM. 10
                                </p>
                                <div class="flex gap-4 mt-4 text-[11px] text-gray-500 font-medium bg-gray-50 p-2 rounded-xl">
                                    <span class="flex items-center gap-1">🛏️ 12 Kamar</span>
                                    <span class="text-green-600 font-semibold flex items-center gap-1">🟢 2 Tersedia</span>
                                </div>
                            </div>
                            
                            <div class="pt-2 border-t border-gray-50">
                                <a href="kost/1"
                                   class="w-full bg-[#071931] hover:bg-opacity-95 text-white text-center block text-xs font-bold py-2.5 rounded-xl cursor-pointer transition shadow-xs">
                                    Kelola & Detail Kost →
                                </a>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>

            <div class="lg:col-span-1 space-y-4">
                <div class="flex items-center gap-2 px-1">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-sm">📊</div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Ikhtisar Bisnis Kost</h3>
                        <p class="text-[11px] text-gray-400">Data performa unit kost riil</p>
                    </div>
                </div>

                <div class="space-y-4">
                    
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 flex items-center justify-between shadow-xs group hover:border-primary/30 transition-all">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Kamar Terisi</span>
                            <h4 class="text-2xl font-black text-gray-900 mt-1.5">
                                42 <span class="text-xs font-normal text-gray-400">/ 50 Unit</span>
                            </h4>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                            🛏️
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 flex items-center justify-between shadow-xs group hover:border-amber-300 transition-all">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Dilihat (Card)</span>
                            <div class="flex items-baseline gap-2 mt-1.5">
                                <h4 class="text-2xl font-black text-gray-900">1,204</h4>
                                <span class="text-[10px] text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded flex items-center gap-0.5">▲ 12%</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm">
                            👁️
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
