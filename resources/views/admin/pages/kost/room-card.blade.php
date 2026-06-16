{{-- MANAJEMEN ROOM --}}
{{-- 1. HEADER --}}
<div class="flex justify-between items-center">
    <h2 class="text-lg font-extrabold text-slate-800">Manajemen Kamar</h2>
    <button type="button" onclick="addLantai()"
        class="bg-[#0F172A] text-white text-sm font-bold px-4 py-2 rounded-xl hover:bg-slate-800 transition cursor-pointer">
        + Tambah Lantai
    </button>
</div>

{{-- 2. FORM UTAMA (Membungkus Seluruh Konten) --}}
<form action="{{ route('superadmin.kost.storeRoom', ['kost_id' => $kost->kost_id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label class="text-[10px] font-bold text-slate-400 uppercase">ID Kost Aktif</label>
        <input type="text" value="{{ request()->segment(3) }}"
            class="w-full bg-slate-100 border border-slate-200 rounded-xl p-2.5 text-sm font-mono" readonly>
    </div>
    {{-- CONTAINER UTAMA --}}
    <div id="lantai-wrapper" class="space-y-6">
        @php
            $lantais = isset($dataKost) && count($dataKost->lantais) > 0 ? $dataKost->lantais : [null];
        @endphp

        @foreach ($lantais as $index => $lantai)
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 lantai-item"
                id="lantai-{{ $index + 1 }}">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> <span class="lantai-label">Lantai
                            {{ $index + 1 }}</span>
                    </h3>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="addTipeKamar('lantai-{{ $index + 1 }}')"
                            class="text-xs font-bold text-amber-600 hover:text-amber-700 cursor-pointer">+ Tambah Tipe
                            Kamar</button>
                        <button type="button" onclick="openDeleteModal(this, 'lantai')"
                            class="text-xs font-bold text-red-500 hover:text-red-700 cursor-pointer">Hapus
                            Lantai</button>
                    </div>
                </div>
                {{-- Container khusus kamar untuk lantai ini --}}
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

    {{-- TOMBOL SIMPAN --}}
    <div class="fixed bottom-6 right-6 z-50">
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold cursor-pointer hover:bg-blue-700 transition shadow-lg">
            Simpan Semua Perubahan
        </button>
    </div>
</form>

{{-- 3. TEMPLATE --}}
<template id="kamar-template">
    @include('admin.components.room-row', ['kamar' => null])
</template>

{{-- 4. MODAL --}}
<div id="modal-delete-lantai" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-xl">
        <h3 class="font-bold text-lg text-slate-800 mb-2">Hapus Lantai?</h3>
        <p class="text-sm text-slate-500 mb-6">Semua kamar di lantai ini akan ikut terhapus.</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal('modal-delete-lantai')"
                class="px-4 py-2 cursor-pointer text-sm font-bold text-slate-600">Batal</button>
            <button type="button" id="confirm-delete-lantai"
                class="px-4 py-2 cursor-pointer text-sm font-bold bg-red-600 text-white rounded-xl">Ya, Hapus</button>
        </div>
    </div>
</div>

<div id="modal-delete-kamar" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-6 rounded-2xl w-full max-w-sm shadow-xl">
        <h3 class="font-bold text-lg text-slate-800 mb-2">Hapus Kamar?</h3>
        <p class="text-sm text-slate-500 mb-6">Tindakan ini tidak bisa dibatalkan.</p>
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
    let lantaiCount = document.querySelectorAll('.lantai-item').length;
    let elementToDelete = null;
    let typeToDelete = null;

    // Sinkronisasi nomor lantai ke setiap input lantai di semua baris
    function updateAllLantaiInputs() {
        document.querySelectorAll('.lantai-item').forEach((lantaiEl, lantaiIndex) => {
            const nomorLantai = lantaiIndex + 1;
            const inputLantais = lantaiEl.querySelectorAll('.input-lantai');
            inputLantais.forEach(input => {
                input.value = nomorLantai;
            });
        });
    }

    function renumberLantai() {
        document.querySelectorAll('.lantai-item').forEach((el, index) => {
            const newId = index + 1;
            el.id = `lantai-${newId}`;
            el.querySelector('.lantai-label').innerText = `Lantai ${newId}`;
            const btn = el.querySelector('button[onclick^="addTipeKamar"]');
            if (btn) btn.setAttribute('onclick', `addTipeKamar('lantai-${newId}')`);
        });
        lantaiCount = document.querySelectorAll('.lantai-item').length;
        updateAllLantaiInputs();
    }

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
        updateAllLantaiInputs();
    }

    function addTipeKamar(lantaiId) {
        const template = document.getElementById('kamar-template');
        const container = document.querySelector(`#${lantaiId} .tipe-kamar-container`);
        container.appendChild(template.content.cloneNode(true));
        // Update lantai untuk baris yang baru ditambahkan
        updateAllLantaiInputs();
    }

    function openDeleteModal(btn, type) {
        typeToDelete = type;
        elementToDelete = btn.closest(type === 'lantai' ? '.lantai-item' : '.kamar-row');
        document.getElementById(type === 'lantai' ? 'modal-delete-lantai' : 'modal-delete-kamar').classList.remove(
            'hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        elementToDelete = null;
    }

    document.getElementById('confirm-delete-lantai').addEventListener('click', () => {
        if (elementToDelete) {
            elementToDelete.remove();
            renumberLantai();
        }
        closeModal('modal-delete-lantai');
    });

    document.getElementById('confirm-delete-kamar').addEventListener('click', () => {
        if (elementToDelete) elementToDelete.remove();
        closeModal('modal-delete-kamar');
    });

    // Delegasi Event Utama
    document.addEventListener('click', function(e) {
        // Upload trigger
        if (e.target.closest('.btn-upload')) {
            e.target.closest('.kamar-row').querySelector('.file-input').click();
        }

        // Tambah Nomor Kamar
        if (e.target.classList.contains('btn-tambah-nomor')) {
            const container = e.target.closest('.nomor-kamar-wrapper');
            const row = e.target.closest('.kamar-row');
            const input = container.querySelector('.input-nomor');
            const val = input.value.trim();
            const hiddenInput = row.querySelector('input[name^="kamar_id"]');
            const uid = hiddenInput.name.match(/\[(.*?)\]/)[1];

            if (val === "") {
                input.focus();
                input.classList.add('border-red-500');
                if (!container.querySelector('.error-msg')) {
                    input.insertAdjacentHTML('afterend',
                        '<span class="error-msg text-[10px] text-red-500 font-bold block mt-1 ml-1">* Nomor kamar wajib diisi!</span>'
                    );
                }
                return;
            }

            input.classList.remove('border-red-500');
            addBadge(container, val, uid);
            input.value = '';
        }
    });

    function addBadge(container, val, uid) {
        const badgesContainer = container.querySelector('.badges-container');
        const badge = document.createElement('div');
        badge.className = "flex items-center gap-1 bg-amber-400 px-3 py-1 rounded-lg text-sm font-medium";
        badge.innerHTML = `
            <span>${val}</span>
            <button type="button" class="hover:text-white cursor-pointer" onclick="this.parentElement.remove()">&times;</button>
            <input type="hidden" name="nomor_kamar[${uid}][]" value="${val}">
        `;
        badgesContainer.appendChild(badge);
    }

    // Event listeners tambahan
    document.addEventListener('change', e => {
        if (e.target.classList.contains('file-input')) {
            const cont = e.target.closest('.kamar-row').querySelector('.preview-container');
            Array.from(e.target.files).forEach(f => {
                const reader = new FileReader();
                reader.onload = ev => cont.insertAdjacentHTML('beforeend',
                    `<div class="relative"><img src="${ev.target.result}" class="w-full h-20 object-cover rounded-xl border"><button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px]" onclick="this.parentElement.remove()"><i class="fa-solid fa-xmark"></i></button></div>`
                );
                reader.readAsDataURL(f);
            });
        }
    });

    document.addEventListener('keydown', e => {
        if (e.target.classList.contains('input-nomor') && e.key === 'Enter') {
            e.preventDefault();
            e.target.nextElementSibling.click();
        }
    });

    document.addEventListener('input', e => {
        if (e.target.classList.contains('input-nomor')) {
            const container = e.target.closest('.nomor-kamar-wrapper');
            const error = container.querySelector('.error-msg');
            if (error) error.remove();
            e.target.classList.remove('border-red-500');
        }
    });
</script>
