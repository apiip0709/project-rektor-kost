@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('superadmin.kost.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 cursor-pointer mb-4">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Kost
            </a>
        </div>

        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Lengkapi Data Kost</h1>
            <form action="{{ route('superadmin.kost.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label for="name_kost" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Nama
                                Kost</label>
                            <input type="text" id="name_kost" name="name_kost" placeholder="Contoh: Kost Mahasiswa Ceria"
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach (['klasifikasi' => 'Klasifikasi', 'city' => 'Kota'] as $id => $label)
                                <div class="flex flex-col">
                                    <label for="{{ $id }}"
                                        class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">{{ $label }}</label>
                                    <div class="relative">
                                        <select id="{{ $id }}" name="{{ $id }}"
                                            class="w-full appearance-none rounded-xl border border-slate-200 py-2.5 pl-3 pr-8 text-sm cursor-pointer hover:border-slate-300 transition focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none bg-white">
                                            @if ($id == 'klasifikasi')
                                                <option value="putra">Putra</option>
                                                <option value="putri">Putri</option>
                                                <option value="campur">Campur</option>
                                            @else
                                                <option value="makassar">Makassar</option>
                                                <option value="gowa">Gowa</option>
                                            @endif
                                        </select>
                                        
                                        <i
                                            class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-[10px] text-slate-400 pointer-events-none"></i>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-span-2 flex flex-col">
                                <label for="campus"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Kampus</label>
                                <div class="relative">
                                    <select id="campus" name="campus"
                                        class="w-full appearance-none rounded-xl border border-slate-200 py-2.5 pl-3 pr-8 text-sm cursor-pointer hover:border-slate-300 transition focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none bg-white">
                                        @foreach (['unhas', 'pnup', 'unitama', 'undipa', 'cokro'] as $c)
                                            <option value="{{ $c }}">{{ strtoupper($c) }}</option>
                                        @endforeach
                                    </select>
                                    <i
                                        class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-[10px] text-slate-400 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Alamat
                                Lengkap</label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase mb-2">Fasilitas
                                Umum</label>
                            <div class="p-3 border border-slate-200 rounded-xl min-h-[48px] bg-slate-50/30">
                                <span class="text-xs text-slate-400 italic">Belum ada fasilitas dipilih.</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Foto
                                Properti</label>
                            <button type="button"
                                class="w-full py-2.5 border border-dashed border-slate-300 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-50 hover:border-slate-400 transition cursor-pointer">
                                <i class="fa-solid fa-camera mr-2"></i> Tambah Foto
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="lat"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Latitude</label>
                                <input type="number" step="any" id="lat" name="latitude"
                                    class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 outline-none">
                            </div>
                            <div>
                                <label for="lng"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Longitude</label>
                                <input type="number" step="any" id="lng" name="longitude"
                                    class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 outline-none">
                            </div>
                        </div>

                        <div>
                            <label for="desc"
                                class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Deskripsi
                                Properti</label>
                            <textarea id="desc" name="description" rows="3"
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer mt-6">
                    Simpan Data Kost
                </button>
            </form>
        </div>
    </div>
@endsection
