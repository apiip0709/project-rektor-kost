@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('superadmin.kost.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 cursor-pointer mb-4">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Kost
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Lengkapi Data Kost</h1>
        </div>

        <form action="#" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                    <i class="fa-solid fa-house-user text-slate-400"></i>
                    <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Informasi Dasar & Lokasi</h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label for="name_kost" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Nama
                                Kost</label>
                            <input type="text" id="name_kost" name="name_kost" placeholder="Contoh: Kost Mahasiswa Ceria"
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition">
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            @foreach (['klasifikasi' => 'Klasifikasi', 'city' => 'Kota', 'campus' => 'Kampus'] as $id => $label)
                                <div>
                                    <label for="{{ $id }}"
                                        class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">{{ $label }}</label>
                                    <select id="{{ $id }}" name="{{ $id }}"
                                        class="w-full rounded-xl border border-slate-200 py-2.5 px-3 text-sm cursor-pointer hover:border-slate-300 transition">
                                        @if ($id == 'klasifikasi')
                                            <option value="putra">Putra</option>
                                            <option value="putri">Putri</option>
                                            <option value="campur">Campur</option>
                                        @elseif($id == 'city')
                                            <option value="makassar">Makassar</option>
                                            <option value="gowa">Gowa</option>
                                        @else
                                            @foreach (['unhas', 'pnup', 'unitama', 'undipa', 'cokro'] as $c)
                                                <option value="{{ $c }}">{{ strtoupper($c) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <label for="address" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Alamat
                                Lengkap</label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase mb-2">Fasilitas Umum</label>
                            <div class="p-3 border border-slate-200 rounded-xl min-h-[48px] bg-slate-50/30">
                                <span class="text-xs text-slate-400 italic">Belum ada fasilitas dipilih.</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Foto Properti</label>
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
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit"
                    class="bg-slate-900 text-white font-bold px-8 py-2.5 rounded-xl hover:bg-slate-800 shadow-lg shadow-slate-200 transition-all">
                    Simpan Properti
                </button>
            </div>
        </form>
    </div>
@endsection
