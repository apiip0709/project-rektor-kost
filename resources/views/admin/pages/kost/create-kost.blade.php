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
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight mb-6">Lengkapi Data Kost</h1>

            {{-- Form dengan id untuk kemudahan manipulasi --}}
            <form id="kostForm" action="{{ route('superadmin.kost.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                @if (request()->has('owner_id'))
                    <input type="hidden" name="owner_id" value="{{ request('owner_id') }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div>
                            <label for="name_kost" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Nama
                                Kost</label>
                            <input type="text" id="name_kost" name="name_kost" required
                                placeholder="Contoh: Kost Mahasiswa Ceria"
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach (['klasifikasi' => 'Klasifikasi', 'city' => 'Kota'] as $id => $label)
                                <div class="flex flex-col">
                                    <label for="{{ $id }}"
                                        class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">{{ $label }}</label>
                                    <div class="relative">
                                        <select id="{{ $id }}" name="{{ $id }}" required
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
                        </div>

                        <div>
                            <label for="address" class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Alamat
                                Lengkap</label>
                            <textarea id="address" name="address" rows="3" required
                                class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 focus:border-blue-400 outline-none transition"></textarea>
                        </div>

                        {{-- Input Kampus (Wajib Diisi) --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase">Kampus Sekitar</label>
                                <button type="button" onclick="kampusModal.showModal()"
                                    class="text-[10px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded-lg transition-all cursor-pointer">
                                    <i class="fa-solid fa-plus mr-1"></i> Tambah
                                </button>
                            </div>
                            <div id="selected-campuses"
                                class="w-full p-3 border border-slate-200 rounded-xl min-h-[48px] bg-slate-50/30">
                                <span class="text-xs text-slate-400 italic">Belum ada kampus dipilih.</span>
                            </div>
                            <input type="hidden" name="campuses_data" id="campuses_data" required>
                        </div>

                        {{-- Input Fasilitas (Wajib Diisi) --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase">Fasilitas Umum</label>
                                <button type="button" onclick="fasilitasModal.showModal()"
                                    class="text-[10px] font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded-lg transition-all cursor-pointer">
                                    <i class="fa-solid fa-plus mr-1"></i> Tambah
                                </button>
                            </div>
                            <div id="selected-facilities"
                                class="w-full p-3 border border-slate-200 rounded-xl min-h-[48px] bg-slate-50/30">
                                <span class="text-xs text-slate-400 italic">Belum ada fasilitas dipilih.</span>
                            </div>
                            <input type="hidden" name="facilities_data" id="facilities_data" required>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Foto Properti</label>
                            <div id="preview-container" class="grid grid-cols-3 gap-2 mb-3"></div>
                            <button type="button" onclick="document.getElementById('file-input').click()"
                                class="w-full py-2.5 border border-dashed border-slate-300 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-50 hover:border-slate-400 transition cursor-pointer">
                                <i class="fa-solid fa-camera mr-2"></i> Tambah Foto
                            </button>
                            <input type="file" id="file-input" name="img_kost[]" multiple required class="hidden"
                                accept="image/*">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="lat"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Latitude</label>
                                <input type="number" step="any" id="lat" name="latitude" required
                                    class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 outline-none">
                            </div>
                            <div>
                                <label for="lng"
                                    class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Longitude</label>
                                <input type="number" step="any" id="lng" name="longitude" required
                                    class="w-full rounded-xl border border-slate-200 py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-50 outline-none">
                            </div>
                        </div>
                        <div>
                            <label for="desc"
                                class="block text-[11px] font-bold text-slate-400 uppercase mb-1.5">Deskripsi Kost</label>
                            <textarea id="desc" name="description" rows="5" required
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
                @foreach (['WiFi', 'Parkir Motor', 'Dapur Bersama', 'AC', 'Laundry'] as $f)
                    <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600">
                        <input type="checkbox" name="facility[]" value="{{ $f }}"
                            class="rounded border-slate-300">
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
        <div class="p-6">
            <h3 class="font-bold text-lg mb-4">Pilih Kampus</h3>
            <div class="space-y-3">
                @foreach (['Unhas', 'Pnup', 'Unitama', 'Undipa', 'Cokro'] as $c)
                    <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600">
                        <input type="checkbox" name="campus[]" value="{{ $c }}"
                            class="rounded border-slate-300">
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
        // Validasi Submit
        document.getElementById('kostForm').addEventListener('submit', function(e) {
            const camp = document.getElementById('campuses_data').value;
            const fac = document.getElementById('facilities_data').value;
            if (!camp || !fac) {
                e.preventDefault();
                alert('Harap lengkapi semua data, termasuk pilihan Kampus dan Fasilitas!');
            }
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

        document.getElementById('file-input').addEventListener('change', function() {
            const container = document.getElementById('preview-container');
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML =
                        `<img src="${e.target.result}" class="w-full h-20 object-cover rounded-xl border"><button type="button" class="absolute cursor-pointer -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[8px]" onclick="this.parentElement.remove()">x</button>`;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
