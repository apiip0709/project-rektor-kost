@extends('admin.layouts.superadmin')

@section('content')
    <div class="space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Ikhtisar Ekosistem</p>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ikhtisar Ekosistem</h1>
            </div>
            <div class="flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-full shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                </span>
                <span class="text-xs font-bold text-slate-600">Update Langsung</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-default">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-sm font-bold text-slate-500 uppercase">Total Pengguna</p>
                    <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                </div>
                <h2 class="text-4xl font-black text-slate-900 mb-2">42,891</h2>
                <div class="flex items-center gap-1.5 text-emerald-600 font-bold text-sm">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>+12% <span class="text-slate-400 font-medium">vs bulan lalu</span></span>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-default">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-sm font-bold text-slate-500 uppercase">Total Pemilik</p>
                    <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-tie text-lg"></i>
                    </div>
                </div>
                <h2 class="text-4xl font-black text-slate-900 mb-2">1,204</h2>
                <div class="flex items-center gap-1.5 text-blue-600 font-bold text-sm">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>+3.4% <span class="text-slate-400 font-medium">vs bulan lalu</span></span>
                </div>
            </div>

            <div
                class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-default">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-sm font-bold text-slate-500 uppercase">Properti Aktif</p>
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-house-chimney text-lg"></i>
                    </div>
                </div>
                <h2 class="text-4xl font-black text-slate-900 mb-2">3,560</h2>
                <div class="flex items-center gap-1.5 text-slate-400 font-bold text-sm">
                    <i class="fa-solid fa-minus"></i>
                    <span>Stabil</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-extrabold text-slate-900">Aktivitas Terbaru</h3>
                    <a href="#" class="text-sm font-bold text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                <div
                    class="bg-white rounded-2xl border border-slate-200 divide-y divide-slate-100 overflow-hidden shadow-sm">
                    <div class="p-4 flex gap-4 items-start hover:bg-slate-50 transition-colors cursor-pointer">
                        <div
                            class="h-10 w-10 shrink-0 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 leading-snug">
                                <span class="font-bold text-slate-900">Kost Rektor Exclusive</span> telah disetujui oleh
                                <span class="font-bold text-slate-900">Admin_01</span>
                            </p>
                            <p class="text-xs text-slate-400 mt-1">2 mnt lalu • Persetujuan Properti</p>
                        </div>
                    </div>
                    <div class="p-4 flex gap-4 items-start hover:bg-slate-50 transition-colors cursor-pointer">
                        <div
                            class="h-10 w-10 shrink-0 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 leading-snug">
                                Pemilik institusi baru <span class="font-bold text-slate-900">PT. Graha Mandiri</span> telah
                                terdaftar.
                            </p>
                            <p class="text-xs text-slate-400 mt-1">15 mnt lalu • Manajemen Pemilik</p>
                        </div>
                    </div>
                    <div class="p-4 flex gap-4 items-start hover:bg-slate-50 transition-colors cursor-pointer">
                        <div
                            class="h-10 w-10 shrink-0 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 leading-snug">
                                Sistem menandai aktivitas booking mencurigakan pada Listing <span
                                    class="font-bold text-slate-900">#8492</span>.
                            </p>
                            <p class="text-xs text-slate-400 mt-1">1 jam lalu • Keamanan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-extrabold text-slate-900">Kesehatan Sistem</h3>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-slate-500">Waktu Aktif Server</span>
                            <span class="text-emerald-600">99.99%</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 99.99%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-slate-500">Beban Database</span>
                            <span class="text-slate-900">42%</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-slate-800 rounded-full" style="width: 42%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-slate-500">Waktu Respon API</span>
                            <span class="text-slate-900">124ms</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Semua sistem beroperasi normal <span
                                class="block text-xs font-medium text-slate-400">Terakhir dicek: Baru saja</span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
