{{-- MANAJEMEN ROOM --}}

{{-- 1. HEADER --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-extrabold text-slate-800">Manajemen Kamar</h2>
    <button type="button" onclick="addLantai()"
        class="bg-[#0F172A] text-white text-sm font-bold px-4 py-2 rounded-xl hover:bg-slate-800 transition cursor-pointer">
        + Tambah Lantai
    </button>
</div>

{{-- 2. CONTAINER UTAMA --}}
<div id="lantai-wrapper" class="space-y-6">
    @php
        $lantais = isset($dataKost) && count($dataKost->lantais) > 0 ? $dataKost->lantais : [null];
    @endphp

    @foreach ($lantais as $index => $lantai)
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 lantai-item" id="lantai-{{ $index + 1 }}">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group"></i> <span class="lantai-label">Lantai {{ $index + 1 }}</span>
                </h3>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="addTipeKamar('lantai-{{ $index + 1 }}')"
                        class="text-xs font-bold text-amber-600 hover:text-amber-700 cursor-pointer">+ Tambah Tipe
                        Kamar</button>
                    <button type="button" onclick="openDeleteModal(this, 'lantai')"
                        class="text-xs font-bold text-red-500 hover:text-red-700 cursor-pointer">Hapus Lantai</button>
                </div>
            </div>
            <div class="tipe-kamar-container space-y-4">
                @if ($lantai && isset($lantai->tipeKamars))
                    @foreach ($lantai->tipeKamars as $kamar)
                        @include('components.kamar-row', ['kamar' => $kamar])
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</div>

{{-- 3. TEMPLATE --}}
<template id="kamar-template">
    @include('admin.components.room-row', ['kamar' => null])
</template>

{{-- 4. MODAL --}}
{{-- MODAL HAPUS LANTAI --}}
<div id="modal-delete-lantai" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-xl">
        <h3 class="font-bold text-lg text-slate-800 mb-2">Hapus Lantai?</h3>
        <p class="text-sm text-slate-500 mb-6">Semua kamar di lantai ini akan ikut terhapus. Yakin ingin melanjutkan?
        </p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-delete-lantai')"
                class="px-4 py-2 cursor-pointer text-sm font-bold text-slate-600">Batal</button>
            <button type="button" id="confirm-delete-lantai"
                class="px-4 py-2 cursor-pointer text-sm font-bold bg-red-600 text-white rounded-xl">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- MODAL HAPUS KAMAR --}}
<div id="modal-delete-kamar" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-xl">
        <h3 class="font-bold text-lg text-slate-800 mb-2">Hapus Kamar?</h3>
        <p class="text-sm text-slate-500 mb-6">Tindakan ini tidak bisa dibatalkan. Yakin ingin menghapus kamar ini?</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-delete-kamar')"
                class="px-4 py-2 cursor-pointer text-sm font-bold text-slate-600">Batal</button>
            <button type="button" id="confirm-delete-kamar"
                class="px-4 py-2 cursor-pointer text-sm font-bold bg-red-600 text-white rounded-xl">Hapus</button>
        </div>
    </div>
</div>

{{-- 5. SCRIPT --}}
<script>
    let lantaiCount = {{ isset($dataKost) ? count($dataKost->lantais) : 1 }};
    let elementToDelete = null;
    let typeToDelete = null; // 'lantai' atau 'kamar'

    // Fungsi untuk reset nomor lantai
    function renumberLantai() {
        const lantais = document.querySelectorAll('.lantai-item');
        lantais.forEach((el, index) => {
            const newId = index + 1;
            el.id = `lantai-${newId}`;
            el.querySelector('.lantai-label').innerText = `Lantai ${newId}`;
            // Update onclick button tambah tipe kamar agar sesuai dengan ID baru
            const btnTambah = el.querySelector('button[onclick^="addTipeKamar"]');
            if (btnTambah) {
                btnTambah.setAttribute('onclick', `addTipeKamar('lantai-${newId}')`);
            }
        });
        lantaiCount = lantais.length;
    }
    // Tambah Lantai
    function addLantai() {
        lantaiCount++;
        const html = `
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 lantai-item" id="lantai-${lantaiCount}">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-slate-700 flex items-center gap-2"><i class="fa-solid fa-layer-group"></i> <span class="lantai-label">Lantai ${lantaiCount}</span></h3>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="addTipeKamar('lantai-${lantaiCount}')" class="text-xs font-bold text-amber-600 hover:text-amber-700 cursor-pointer">+ Tambah Tipe Kamar</button>
                    <button type="button" onclick="openDeleteModal(this, 'lantai')" class="text-xs font-bold text-red-500 hover:text-red-700 cursor-pointer">Hapus Lantai</button>
                </div>
            </div>
            <div class="tipe-kamar-container space-y-4"></div>
        </div>`;
        document.getElementById('lantai-wrapper').insertAdjacentHTML('beforeend', html);
    }
    // Tambah Tipe Kamar
    function addTipeKamar(lantaiId) {
        const template = document.getElementById('kamar-template');
        const clone = template.content.cloneNode(true);
        document.querySelector(`#${lantaiId} .tipe-kamar-container`).appendChild(clone);
    }

    // Modal Controller
    function openDeleteModal(btn, type) {
        typeToDelete = type;
        elementToDelete = (type === 'lantai') ? btn.closest('.lantai-item') : btn.closest('.kamar-row');
        const modalId = (type === 'lantai') ? 'modal-delete-lantai' : 'modal-delete-kamar';
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        elementToDelete = null;
    }

    // Listener Hapus Lantai
    document.getElementById('confirm-delete-lantai').addEventListener('click', function() {
        if (elementToDelete && typeToDelete === 'lantai') {
            elementToDelete.remove();
            renumberLantai();
        }
        closeModal('modal-delete-lantai');
    });

    // Listener Hapus Kamar
    document.getElementById('confirm-delete-kamar').addEventListener('click', function() {
        if (elementToDelete && typeToDelete === 'kamar') {
            elementToDelete.remove();
        }
        closeModal('modal-delete-kamar');
    });

    // Delegasi Event untuk Foto
    document.addEventListener('click', e => {
        if (e.target.closest('.btn-upload')) e.target.closest('.kamar-row').querySelector('.file-input')
            .click();
    });

    document.addEventListener('change', e => {
        if (e.target.classList.contains('file-input')) {
            const container = e.target.closest('.kamar-row').querySelector('.preview-container');
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = ev => {
                    container.insertAdjacentHTML('beforeend', `
                        <div class="relative group">
                            <img src="${ev.target.result}" class="w-full h-20 object-cover rounded-xl border">
                            <button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px]" onclick="this.parentElement.remove()">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>`);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // Delegasi Event untuk Tambah Nomor Kamar
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-tambah-nomor')) {
            const container = e.target.closest('.nomor-kamar-wrapper');
            const input = container.querySelector('.input-nomor');
            const val = input.value.trim();

            if (val !== "") {
                addBadge(container, val);
                input.value = ''; // Reset input
            }
        }
    });

    // Fungsi untuk membuat badge
    function addBadge(container, value) {
        const badgesContainer = container.querySelector('.badges-container');
        const badge = document.createElement('div');
        badge.className = "flex items-center gap-1 bg-amber-400 px-3 py-1 rounded-lg text-sm font-medium";
        badge.innerHTML = `
        <span>${value}</span>
        <button type="button" class="hover:text-white cursor-pointer" onclick="this.parentElement.remove()">&times;</button>
        <input type="hidden" name="nomor_kamar[]" value="${value}">
    `;
        badgesContainer.appendChild(badge);
    }

    // Tambahkan fitur tekan Enter untuk tambah
    document.addEventListener('keydown', function(e) {
        if (e.target.classList.contains('input-nomor') && e.key === 'Enter') {
            e.preventDefault();
            e.target.nextElementSibling.click(); // Trigger tombol +
        }
    });
</script>
