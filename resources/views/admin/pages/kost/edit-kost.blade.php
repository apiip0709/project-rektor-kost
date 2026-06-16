@extends('admin.layouts.superadmin')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div id="success-alert"
                class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm flex justify-between items-center mb-6 animate-in fade-in slide-in-from-top-2 duration-300">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('success-alert').remove()"
                    class="text-emerald-600 hover:text-emerald-800 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
        {{-- Pesan Error (dari Controller atau Validasi) --}}
        @if (session('error'))
            <div id="error-alert"
                class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm mb-6 animate-in fade-in slide-in-from-top-2 duration-300 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="document.getElementById('error-alert').remove()"
                    class="text-red-600 hover:text-red-800 cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('superadmin.kost.index') }}"
                class="text-sm text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 cursor-pointer mb-4">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Kost
            </a>
        </div>

        {{-- Layout Grid 1:3 --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

            {{-- KOLOM KIRI (1 Bagian): EDIT FORM --}}
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                <h1 class="text-xl font-extrabold text-slate-800 tracking-tight mb-5">Edit Data Kost</h1>

                <form id="kostForm" action="{{ route('superadmin.kost.update', $kost->kost_id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="owner_id" value="{{ $kost->owner_id ?? '' }}">

                    {{-- Nama Kost --}}
                    <div>
                        <label for="name_kost" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama
                            Kost</label>
                        <input type="text" id="name_kost" name="name_kost"
                            value="{{ old('name_kost', $kost->name_kost) }}" required
                            class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm focus:ring-2 focus:ring-slate-900 outline-none transition">
                    </div>

                    {{-- Klasifikasi --}}
                    <div>
                        <label for="klasifikasi"
                            class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Klasifikasi</label>
                        <select id="klasifikasi" name="klasifikasi"
                            class="w-full cursor-pointer rounded-xl border border-slate-200 py-2 px-3 text-sm bg-white outline-none">
                            @foreach (['putra', 'putri', 'campur'] as $k)
                                <option value="{{ $k }}" {{ $kost->klasifikasi == $k ? 'selected' : '' }}>
                                    {{ ucfirst($k) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kota --}}
                    <div>
                        <label for="city" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kota</label>
                        <select id="city" name="city"
                            class="w-full cursor-pointer rounded-xl border border-slate-200 py-2 px-3 text-sm bg-white outline-none">
                            <option value="makassar" {{ $kost->city == 'makassar' ? 'selected' : '' }}>Makassar</option>
                            <option value="gowa" {{ $kost->city == 'gowa' ? 'selected' : '' }}>Gowa</option>
                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="address" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Alamat
                            Lengkap</label>
                        <textarea id="address" name="address" rows="2" required
                            class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm outline-none transition">{{ old('address', $kost->address) }}</textarea>
                    </div>

                    {{-- Titik Koordinat (Dipisah Kiri & Kanan) --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="latitude"
                                class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Latitude</label>
                            <input type="text" id="latitude" name="latitude"
                                value="{{ old('latitude', $kost->latitude ?? '') }}" placeholder="-5.1332"
                                class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm outline-none transition">
                        </div>
                        <div>
                            <label for="longitude"
                                class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Longitude</label>
                            <input type="text" id="longitude" name="longitude"
                                value="{{ old('longitude', $kost->longitude ?? '') }}" placeholder="119.4883"
                                class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm outline-none transition">
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto Properti</span>
                        <div id="preview-container" class="grid grid-cols-3 gap-2 mb-2">
                            @foreach ((array) json_decode($kost->img_kost) as $index => $img)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $img) }}" alt="Foto properti kost"
                                        class="w-full h-14 object-cover rounded-lg border">
                                    <button type="button" onclick="removeExisting(this)" data-path="{{ $img }}"
                                        class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[8px] cursor-pointer opacity-0 group-hover:opacity-100"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="document.getElementById('file-input').click()"
                            class="w-full py-2 border border-dashed border-slate-300 rounded-xl text-[10px] font-bold text-slate-500 hover:bg-slate-50 transition cursor-pointer">
                            + Tambah Foto
                        </button>
                        <input type="file" id="file-input" name="img_kost[]" multiple class="hidden" accept="image/*">
                    </div>

                    {{-- Kampus Sekitar --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Kampus Sekitar</span>
                            <button type="button" onclick="kampusModal.showModal()"
                                class="text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded cursor-pointer">Ubah</button>
                        </div>
                        <div id="selected-campuses"
                            class="w-full p-2 border border-slate-200 rounded-xl bg-slate-50 text-xs min-h-[36px]">
                            {{ is_array($cList = json_decode($kost->campus)) ? implode(', ', $cList) : $kost->campus }}
                        </div>
                        <input type="hidden" name="campuses_data" id="campuses_data" value="{{ $kost->campus }}">
                    </div>

                    {{-- Fasilitas Umum --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Fasilitas Umum</span>
                            <button type="button" onclick="fasilitasModal.showModal()"
                                class="text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded cursor-pointer">Ubah</button>
                        </div>
                        <div id="selected-facilities"
                            class="w-full p-2 border border-slate-200 rounded-xl bg-slate-50 text-xs min-h-[36px]">
                            {{ is_array($fList = json_decode($kost->facility)) ? implode(', ', $fList) : $kost->facility }}
                        </div>
                        <input type="hidden" name="facilities_data" id="facilities_data"
                            value="{{ $kost->facility }}">
                    </div>

                    {{-- Deskripsi Kost --}}
                    <div>
                        <label for="desc" class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi
                            Kost</label>
                        <textarea id="desc" name="description" rows="4" required
                            class="w-full rounded-xl border border-slate-200 py-2 px-3 text-sm focus:ring-2 focus:ring-slate-900 outline-none transition">{{ old('description', $kost->description ?? '') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#0F172A] text-white font-bold text-sm py-3 rounded-xl hover:bg-slate-800 transition cursor-pointer mt-2">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="lg:col-span-3">
                @include('admin.pages.kost.room-card')
            </div>
        </div>
    </div>

    {{-- Modal Fasilitas --}}
    <dialog id="fasilitasModal"
        class="p-0 rounded-2xl shadow-xl w-full max-w-xs backdrop:bg-slate-900/50 fixed inset-0 m-auto">
        <div class="p-6 relative">
            <h3 class="font-bold text-lg mb-4">Pilih Fasilitas</h3>
            <button type="button" onclick="this.closest('dialog').close()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-900 transition-colors p-2 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="space-y-3">
                @php $currentFac = json_decode($kost->facility ?? '[]', true) ?? []; @endphp
                @foreach (['WiFi', 'Parkir Motor', 'Dapur Bersama', 'AC', 'Laundry'] as $f)
                    <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600">
                        <input type="checkbox" name="facility[]" value="{{ $f }}"
                            {{ in_array($f, $currentFac) ? 'checked' : '' }}
                            class="rounded border-slate-300 cursor-pointer">
                        <span>{{ $f }}</span>
                    </label>
                @endforeach
                <button type="button" onclick="saveFacilities()"
                    class="w-full mt-4 bg-slate-900 text-white py-2 rounded-xl font-bold cursor-pointer">Simpan
                    Pilihan</button>
            </div>
        </div>
    </dialog>

    {{-- Modal Kampus --}}
    <dialog id="kampusModal"
        class="p-0 rounded-2xl shadow-xl w-full max-w-xs backdrop:bg-slate-900/50 fixed inset-0 m-auto">
        <div class="p-6 relative">
            <h3 class="font-bold text-lg mb-4">Pilih Kampus</h3>
            <button type="button" onclick="this.closest('dialog').close()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-900 transition-colors p-2 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="space-y-3">
                @php $currentCamp = json_decode($kost->campus ?? '[]', true) ?? []; @endphp
                @foreach (['Unhas', 'Pnup', 'Unitama', 'Undipa', 'Cokro'] as $c)
                    <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600">
                        <input type="checkbox" name="campus[]" value="{{ $c }}"
                            {{ in_array($c, $currentCamp) ? 'checked' : '' }}
                            class="rounded border-slate-300 cursor-pointer">
                        <span>{{ $c }}</span>
                    </label>
                @endforeach
                <button type="button" onclick="saveCampuses()"
                    class="w-full mt-4 bg-slate-900 text-white py-2 rounded-xl font-bold cursor-pointer">Simpan
                    Pilihan</button>
            </div>
        </div>
    </dialog>

    <script>
        // Array untuk menampung path gambar yang akan dihapus
        let removedImages = [];

        function removeExisting(btn) {
            const path = btn.getAttribute('data-path');
            removedImages.push(path);
            document.getElementById('removed_images').value = JSON.stringify(removedImages);
            btn.parentElement.remove(); // Hapus tampilan dari layar
        }

        // Update untuk preview foto baru
        document.getElementById('file-input').addEventListener('change', function() {
            const container = document.getElementById('preview-container');
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-20 object-cover rounded-xl border">
                    <button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] cursor-pointer" onclick="this.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>`;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });

        // Fungsi untuk menutup modal saat klik di luar area dialog (opsional)
        document.querySelectorAll('dialog').forEach(dialog => {
            dialog.addEventListener('click', e => {
                if (e.target === dialog) dialog.close();
            });
        });

        function saveFacilities() {
            const container = document.getElementById('selected-facilities');
            const hiddenInput = document.getElementById('facilities_data');
            const checked = document.querySelectorAll('input[name="facility[]"]:checked');
            const values = Array.from(checked).map(cb => cb.value);

            container.innerHTML = values.length ?
                `<span class="text-sm font-medium text-slate-700">${values.join(', ')}</span>` :
                '<span class="text-xs text-slate-400 italic">Belum ada fasilitas dipilih.</span>';

            hiddenInput.value = values.length ? JSON.stringify(values) : "";
            document.getElementById('fasilitasModal').close();
        }

        function saveCampuses() {
            const container = document.getElementById('selected-campuses');
            const hiddenInput = document.getElementById('campuses_data');
            const checked = document.querySelectorAll('input[name="campus[]"]:checked');
            const values = Array.from(checked).map(cb => cb.value);

            container.innerHTML = values.length ?
                `<span class="text-sm font-medium text-slate-700">${values.join(', ')}</span>` :
                '<span class="text-xs text-slate-400 italic">Belum ada kampus dipilih.</span>';

            hiddenInput.value = values.length ? JSON.stringify(values) : "";
            document.getElementById('kampusModal').close();
        }
    </script>
@endsection
