@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-2">
    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
        <a href="/" class="hover:text-primary flex items-center gap-1">← Kembali ke Hasil Pencarian</a>
        <span>/</span>
        <a href="#" class="hover:text-primary">Tamalanrea</a>
        <span>/</span>
        <span class="text-neutral font-medium">Kost Eksklusif Bintang</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 rounded-xl overflow-hidden h-[350px] md:h-[450px] mb-6 shadow-xs">
        <div class="md:col-span-2 h-full bg-gray-200 relative">
            <div class="absolute top-4 left-4 bg-amber-400 text-primary text-[10px] font-black px-2 py-1 rounded-sm uppercase tracking-wider">Exclusive</div>
            <div class="w-full h-full flex items-center justify-center bg-gray-300 text-primary/40 font-bold text-lg">📁 Foto Utama Kost (Besar)</div>
        </div>
        <div class="hidden md:flex flex-col gap-2 md:col-span-1 h-full">
            <div class="h-1/2 bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">📁 Foto 2</div>
            <div class="h-1/2 bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">📁 Foto 3</div>
        </div>
        <div class="hidden md:flex flex-col gap-2 md:col-span-1 h-full">
            <div class="h-1/2 bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">📁 Foto 4</div>
            <div class="h-1/2 bg-gray-200 flex items-center justify-center text-xs text-gray-400 font-bold">📁 Foto 5</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                <div>
                    <h1 class="text-2xl font-black text-primary">Kost Eksklusif Bintang</h1>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">📍 Jl. Perintis Kemerdekaan Km. 10, Tamalanrea, Makassar</p>
                    
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        <span class="bg-gray-100 text-neutral text-[10px] font-bold px-2 py-1 rounded-md border border-gray-200 flex items-center gap-1">📶 WiFi Cepat</span>
                        <span class="bg-gray-100 text-neutral text-[10px] font-bold px-2 py-1 rounded-md border border-gray-200 flex items-center gap-1">❄️ Full AC</span>
                        <span class="bg-gray-100 text-neutral text-[10px] font-bold px-2 py-1 rounded-md border border-gray-200 flex items-center gap-1">🚿 Kamar Mandi Dalam</span>
                        <span class="bg-gray-100 text-neutral text-[10px] font-bold px-2 py-1 rounded-md border border-gray-200 flex items-center gap-1">🅿️ Parkir Luas</span>
                    </div>
                </div>
                <div class="flex gap-1.5">
                    <button class="border border-gray-200 p-2 rounded-lg hover:bg-gray-50 text-xs">🔗</button>
                    <button class="border border-gray-200 p-2 rounded-lg hover:bg-gray-50 text-xs">🤍</button>
                </div>
            </div>

            <div>
                <h2 class="text-base font-bold text-primary mb-2">Tentang Kost Ini</h2>
                <div class="text-xs text-gray-600 leading-relaxed space-y-3">
                    <p>Kost Eksklusif Bintang menawarkan standar hunian premium untuk profesional dan mahasiswa pascasarjana di area Tamalanrea. Mengedepankan privasi, kenyamanan, dan keamanan, properti ini dikelola dengan standar manajemen profesional Rektor-Kost. Terletak strategis hanya 5 menit dari Universitas Hasanuddin dan area perkantoran utama.</p>
                    <p>Setiap kamar didesain dengan konsep modern minimalis, memastikan sirkulasi udara dan pencahayaan alami yang optimal. Kebersihan area umum dijaga setiap hari oleh staf kami, memberikan pengalaman tinggal layaknya di hotel bintang standar.</p>
                </div>
            </div>

            <div>
                <h2 class="text-base font-bold text-primary mb-3">Tipe Kamar Tersedia</h2>
                <div class="space-y-3">
                    <div class="border border-gray-100 rounded-xl p-4 bg-white flex flex-col sm:flex-row gap-4 items-center justify-between hover:border-gray-200 transition">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">🖼️ Foto</div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-neutral">Tipe Standard (3×4m)</h4>
                                    <span class="bg-amber-100 text-amber-800 text-[9px] font-bold px-1.5 py-0.5 rounded">Sisa 2 Kamar</span>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1">🛏️ Kasur 120x200  •  ❄️ AC  •  🚿 KM Dalam  •  🪑 Meja Kerja</p>
                            </div>
                        </div>
                        <div class="text-right w-full sm:w-auto flex sm:flex-col items-center sm:items-end justify-between pt-3 sm:pt-0 border-t sm:border-0 border-gray-100">
                            <div>
                                <span class="text-base font-black text-primary">Rp 2.000.000</span>
                                <span class="text-[10px] text-gray-400">/ bulan</span>
                            </div>
                            <button class="bg-white text-primary border border-primary hover:bg-gray-50 text-xs font-bold px-4 py-2 rounded-lg mt-2 transition">Pilih Kamar</button>
                        </div>
                    </div>

                    <div class="border border-gray-100 rounded-xl p-4 bg-white flex flex-col sm:flex-row gap-4 items-center justify-between hover:border-gray-200 transition">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">🖼️ Foto</div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-neutral">Tipe Premium (4×5m)</h4>
                                    <span class="bg-red-100 text-red-800 text-[9px] font-bold px-1.5 py-0.5 rounded">Sisa 1 Kamar</span>
                                    <span class="bg-secondary text-primary text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">Populer</span>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1">🛏️ Kasur 160x200  •  📺 Smart TV  •  🧊 Kulkas Mini  •  ♨️ Water Heater</p>
                            </div>
                        </div>
                        <div class="text-right w-full sm:w-auto flex sm:flex-col items-center sm:items-end justify-between pt-3 sm:pt-0 border-t sm:border-0 border-gray-100">
                            <div>
                                <span class="text-base font-black text-primary">Rp 3.500.000</span>
                                <span class="text-[10px] text-gray-400">/ bulan</span>
                            </div>
                            <button class="bg-white text-primary border border-primary hover:bg-gray-50 text-xs font-bold px-4 py-2 rounded-lg mt-2 transition">Pilih Kamar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-base font-bold text-primary mb-2">Lokasi & Akses</h2>
                <div class="w-full h-48 bg-gray-100 rounded-xl flex flex-col items-center justify-center text-gray-400 border border-gray-200 text-xs gap-1">
                    <span>🗺️</span>
                    <span>Peta Interaktif Radius Lokasi Tamalanrea</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                    <div class="bg-white p-3 rounded-xl border border-gray-100 flex items-center gap-3">
                        <span class="text-lg">🎓</span>
                        <div>
                            <h5 class="text-xs font-bold text-neutral">Universitas Hasanuddin</h5>
                            <p class="text-[10px] text-gray-400">1.5 km - 5 Menit berkendara</p>
                        </div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-gray-100 flex items-center gap-3">
                        <span class="text-lg">🏥</span>
                        <div>
                            <h5 class="text-xs font-bold text-neutral">RSUP Dr. Wahidin Sudirohusodo</h5>
                            <p class="text-[10px] text-gray-400">2.0 km - 8 Menit berkendara</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-xs sticky top-24 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-neutral">Tertarik dengan Kost ini?</h3>
                    <p class="text-[11px] text-gray-400 mt-1">Hubungi tim admin kami untuk informasi lebih lanjut atau jadwalkan kunjungan (survey).</p>
                </div>

                <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <div class="w-10 h-10 bg-primary/10 text-primary font-bold text-xs rounded-full flex items-center justify-center">RK</div>
                    <div>
                        <h4 class="text-xs font-bold text-neutral">Admin Rektor-Kost</h4>
                        <p class="text-[10px] text-gray-400">Tamalanrea Area</p>
                    </div>
                </div>

                <button class="w-full bg-primary text-white text-xs font-bold py-3 rounded-lg flex items-center justify-center gap-2 hover:bg-opacity-95 transition shadow-xs">
                    📅 Jadwalkan Survey
                </button>

                <button class="w-full bg-[#128C7E] text-white text-xs font-bold py-3 rounded-lg flex items-center justify-center gap-2 hover:bg-opacity-95 transition shadow-xs">
                    💬 Hubungi Admin via WA
                </button>

                <div class="pt-2 border-t border-gray-100 flex items-start gap-1.5 text-[10px] text-gray-400 leading-normal">
                    <span>🛡️</span>
                    <p>Properti ini dikelola langsung oleh Rektor-Kost. Pembayaran aman dan terjamin.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
