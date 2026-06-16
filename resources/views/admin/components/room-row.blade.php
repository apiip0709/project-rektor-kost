{{-- komponen: kamar-row.blade.php --}}
@props(['kamar' => null])
@php
    $uid = $kamar->id ?? uniqid('kamar_');
@endphp

<div class="bg-white p-5 rounded-2xl border border-slate-200 grid grid-cols-1 md:grid-cols-4 gap-6 kamar-row relative">

    {{-- HIDDEN INPUT UNTUK IDENTIFIKASI --}}
    <input type="hidden" name="kamar_id[{{ $uid }}]" value="{{ $kamar->id ?? '' }}">

    {{-- TOMBOL HAPUS --}}
    <button type="button" onclick="openDeleteModal(this, 'kamar')"
        class="absolute cursor-pointer top-3 right-3 text-red-400 hover:text-red-600 transition" aria-label="Hapus kamar">
        <i class="fa-solid fa-trash-can"></i>
    </button>

    {{-- Kiri: Foto --}}
    <div>
        <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Foto Properti</label>
        <div class="preview-container grid grid-cols-3 gap-2 mb-3"></div>

        <button type="button"
            class="btn-upload w-full py-2.5 border border-dashed border-slate-300 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-50 cursor-pointer">
            <i class="fa-solid fa-camera mr-2"></i> {{ $kamar ? 'Ubah' : 'Tambah' }} Foto
        </button>
        {{-- Input File --}}
        <input type="file" name="img_kost[{{ $uid }}][]" multiple class="hidden file-input" accept="image/*"
            {{ !$kamar ? 'required' : '' }}>
    </div>

    {{-- Kanan: Form --}}
    <div class="md:col-span-3 space-y-4">

        {{-- Nomor Kamar --}}
        <div class="nomor-kamar-wrapper space-y-2">
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nomor Kamar</label>
            <div class="badges-container flex flex-wrap gap-2 mb-2"></div>
            <div class="flex gap-2">
                <input type="text" placeholder="Ketik nomor kamar..."
                    class="input-nomor w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
                <button type="button"
                    class="btn-tambah-nomor cursor-pointer bg-slate-900 text-white px-4 rounded-xl font-bold">+</button>
            </div>
        </div>

        {{-- Ukuran & Lantai --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ukuran Kamar</label>
                <input type="text" name="ukuran_kamar[{{ $uid }}]" required
                    value="{{ $kamar->ukuran ?? '' }}" placeholder="Contoh: 3x4 m"
                    class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Lantai</label>
                <input type="number" name="lantai_room[{{ $uid }}]" value="{{ $kamar->floor_room ?? 1 }}"
                    class="input-lantai w-full text-sm border border-slate-200 rounded-xl p-2.5 bg-slate-100 outline-none"
                    readonly>
            </div>
        </div>

        {{-- Harga --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga / Bulan</label>
                <input type="number" name="harga_bulan[{{ $uid }}]" required
                    value="{{ $kamar->price ?? '' }}" placeholder="Rp"
                    class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga / Tahun</label>
                <input type="number" name="harga_tahun[{{ $uid }}]" value="{{ $kamar->price_year ?? '' }}"
                    placeholder="Rp"
                    class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi Tambahan</label>
            <textarea name="deskripsi_kamar[{{ $uid }}]" required placeholder="Contoh: Jendela menghadap taman"
                class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition h-20">{{ $kamar->description ?? '' }}</textarea>
        </div>
    </div>
</div>
