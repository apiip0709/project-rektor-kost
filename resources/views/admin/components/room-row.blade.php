{{-- komponen: kamar-row.blade.php --}}
@props(['kamar' => null])
@php
    $uid = uniqid('kamar_');
@endphp

{{-- Pembungkus utama --}}
<div class="bg-white p-5 rounded-2xl border border-slate-200 grid grid-cols-1 md:grid-cols-4 gap-6 kamar-row relative">

    {{-- TOMBOL HAPUS (Memanggil fungsi global openDeleteModal) --}}
    <button type="button" onclick="openDeleteModal(this, 'kamar')"
        class="absolute cursor-pointer top-3 right-3 text-red-400 hover:text-red-600 transition" aria-label="Hapus kamar">
        <i class="fa-solid fa-trash-can"></i>
    </button>

    {{-- Kiri: Foto --}}
    <div>
        <label for="file-input-{{ $uid }}"
            class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Foto Properti</label>
        <div class="preview-container grid grid-cols-3 gap-2 mb-3">
            @if ($kamar && $kamar->images)
                @foreach ($kamar->images as $img)
                    <div class="relative group">
                        <img src="{{ $img->url }}" alt="Foto kamar {{ $kamar->nomor ?? 'baru' }}"
                            class="w-full h-20 object-cover rounded-xl border">
                        <button type="button" onclick="removeExisting(this)" data-path="{{ $img->url }}"
                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="button"
            class="btn-upload w-full py-2.5 border border-dashed border-slate-300 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-50 cursor-pointer">
            <i class="fa-solid fa-camera mr-2" aria-hidden="true"></i> {{ $kamar ? 'Ubah' : 'Tambah' }} Foto
        </button>
        <input type="file" id="file-input-{{ $uid }}" name="img_kost[]" multiple class="hidden file-input"
            accept="image/*">
    </div>

    {{-- Kanan: Form --}}
    <div class="md:col-span-3 space-y-4">
        <div>
            <label for="nomor_{{ $uid }}"
                class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nomor Kamar</label>
            <input type="text" id="nomor_{{ $uid }}" name="nomor_kamar[]" value="{{ $kamar->nomor ?? '' }}"
                placeholder="Ketik nomor kamar..."
                class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
        </div>

        <div>
            <label for="ukuran_{{ $uid }}"
                class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ukuran Kamar</label>
            <input type="text" id="ukuran_{{ $uid }}" name="ukuran_kamar[]"
                value="{{ $kamar->ukuran ?? '' }}" placeholder="Contoh: 3x4 m"
                class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="harga_b_{{ $uid }}"
                    class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga / Bulan</label>
                <input type="number" id="harga_b_{{ $uid }}" name="harga_bulan[]"
                    value="{{ $kamar->harga_bulan ?? '' }}" placeholder="Rp"
                    class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
            </div>
            <div>
                <label for="harga_t_{{ $uid }}"
                    class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga / Tahun</label>
                <input type="number" id="harga_t_{{ $uid }}" name="harga_tahun[]"
                    value="{{ $kamar->harga_tahun ?? '' }}" placeholder="Rp"
                    class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition">
            </div>
        </div>

        <div>
            <label for="desc_{{ $uid }}"
                class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi Tambahan</label>
            <textarea id="desc_{{ $uid }}" name="deskripsi_kamar[]" placeholder="Contoh: Jendela menghadap taman"
                class="w-full text-sm border border-slate-200 rounded-xl p-2.5 outline-none focus:ring-2 focus:ring-slate-900 transition h-20">{{ $kamar->deskripsi ?? '' }}</textarea>
        </div>
    </div>
</div>

