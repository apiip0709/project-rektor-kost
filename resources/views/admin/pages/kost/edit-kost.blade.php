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
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight mb-6">Edit Data Kost</h1>

            <form id="kostForm" action="{{ route('superadmin.kost.update', $kost->kost_id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <input type="hidden" name="owner_id" value="{{ $kost->owner_id ?? '' }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div>
                            <label for="name_kost" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Nama
                                Kost</label>
                            <input type="text" id="name_kost" name="name_kost"
                                value="{{ old('name_kost', $kost->name_kost) }}" required
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label for="klasifikasi"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Klasifikasi</label>
                                <select id="klasifikasi" name="klasifikasi"
                                    class="w-full cursor-pointer rounded-xl border border-slate-200 py-2.5 px-3 bg-white">
                                    @foreach (['putra', 'putri', 'campur'] as $k)
                                        <option value="{{ $k }}"
                                            {{ $kost->klasifikasi == $k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label for="city"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Kota</label>
                                <select id="city" name="city"
                                    class="w-full cursor-pointer rounded-xl border border-slate-200 py-2.5 px-3 bg-white">
                                    <option value="makassar" {{ $kost->city == 'makassar' ? 'selected' : '' }}>Makassar
                                    </option>
                                    <option value="gowa" {{ $kost->city == 'gowa' ? 'selected' : '' }}>Gowa</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Alamat
                                Lengkap</label>
                            <textarea id="address" name="address" rows="3" required
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition">{{ old('address', $kost->address) }}</textarea>
                        </div>

                        {{-- Kampus & Fasilitas tidak perlu 'for' jika menggunakan tombol pemicu modal --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[11px] font-bold text-slate-400 uppercase">Kampus Sekitar</span>
                                <button type="button" onclick="kampusModal.showModal()"
                                    class="text-[10px] cursor-pointer font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Ubah</button>
                            </div>
                            <div id="selected-campuses"
                                class="w-full p-3 border border-slate-200 rounded-xl bg-slate-50/30">
                                <span
                                    class="text-sm">{{ is_array($cList = json_decode($kost->campus)) ? implode(', ', $cList) : $kost->campus }}</span>
                            </div>
                            <input type="hidden" name="campuses_data" id="campuses_data" value="{{ $kost->campus }}">
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[11px] font-bold text-slate-400 uppercase">Fasilitas Umum</span>
                                <button type="button" onclick="fasilitasModal.showModal()"
                                    class="text-[10px] cursor-pointer font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Ubah</button>
                            </div>
                            <div id="selected-facilities"
                                class="w-full p-3 border border-slate-200 rounded-xl bg-slate-50/30">
                                <span
                                    class="text-sm">{{ is_array($fList = json_decode($kost->facility)) ? implode(', ', $fList) : $kost->facility }}</span>
                            </div>
                            <input type="hidden" name="facilities_data" id="facilities_data"
                                value="{{ $kost->facility }}">
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-4">
                        <div>
                            <span class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Foto Properti</span>
                            <div id="preview-container" class="grid grid-cols-3 gap-2 mb-3">
                                @foreach ((array) json_decode($kost->img_kost) as $index => $img)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Foto Kost {{ $index + 1 }}"
                                            class="w-full h-20 object-cover rounded-xl border">
                                        <button type="button" onclick="removeExisting(this)"
                                            data-path="{{ $img }}"
                                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px] cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="document.getElementById('file-input').click()"
                                class="w-full py-2.5 cursor-pointer border border-dashed border-slate-300 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-50">Tambah/Ganti
                                Foto</button>
                            <input type="file" id="file-input" name="img_kost[]" multiple class="hidden"
                                accept="image/*">
                            <input type="hidden" name="removed_images" id="removed_images" value="[]">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="latitude"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Latitude</label>
                                <input type="number" id="latitude" step="any" name="latitude"
                                    value="{{ $kost->latitude }}" required
                                    class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm outline-none">
                            </div>
                            <div>
                                <label for="longitude"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Longitude</label>
                                <input type="number" id="longitude" step="any" name="longitude"
                                    value="{{ $kost->longitude }}" required
                                    class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm outline-none">
                            </div>
                        </div>
                        <div>
                            <label for="description"
                                class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Deskripsi</label>
                            <textarea id="description" name="description" rows="5" required
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm outline-none">{{ old('description', $kost->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#0F172A] text-white font-bold py-3 rounded-lg hover:bg-slate-800 transition-all cursor-pointer mt-6">
                    Simpan Perubahan
                </button>
            </form>
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
