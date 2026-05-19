@extends('owner.layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6 p-2 pb-12">

        <div class="border-b border-gray-100 pb-4">
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Tambah Kamar Kost Baru</h1>
            <p class="text-xs text-gray-500 mt-1">
                <a href="{{ route('kelola') }}"
                    class="text-xs text-primary font-bold hover:underline inline-flex items-center gap-1">
                    ← Kelola
                </a>
                <span class="text-gray-300">/</span>
                <span>Input detail kost, fasilitas umum, dan manajemen tipe kamar Anda.</span>
            </p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                <div class="lg:col-span-1 space-y-6">

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs space-y-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <span>ℹ️</span> Informasi Umum
                        </h3>

                        <div>
                            <label for="nama_kost" class="block text-xs font-semibold text-gray-500 mb-1">Nama Kost</label>
                            <input type="text" id="nama_kost" name="nama_kost" placeholder="e.g. Kost Mahasiswa Mawar Biru"
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label for="alamat" class="block text-xs font-semibold text-gray-500 mb-1">Alamat Lengkap (Admin Only)</label>
                            <textarea id="alamat" name="alamat" rows="3" placeholder="Jl. Perintis Kemerdekaan KM. 10..."
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary resize-none"></textarea>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <span>🏢</span> Fasilitas Umum
                            </h3>
                            <button type="button" onclick="openFasilitasModal()"
                                class="w-6 h-6 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 hover:bg-primary hover:text-white hover:border-primary cursor-pointer transition">
                                ＋
                            </button>
                        </div>

                        <div id="wrapper-fasilitas" class="flex flex-wrap gap-2">
                            
                        </div>

                        <div>
                            <label for="deskripsi_fasilitas" class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Fasilitas</label>
                            <textarea id="deskripsi_fasilitas" name="deskripsi_fasilitas" rows="4"
                                placeholder="Area parkir luas cukup untuk 15 motor dengan CCTV 24 jam..."
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary resize-none"></textarea>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs space-y-6">
                        <div class="flex justify-between items-center border-b border-gray-50 pb-3">
                            <h2 class="text-base font-black text-gray-900">Manajemen Kamar</h2>
                            <button type="button"
                                class="bg-[#071931] text-white text-xs font-bold px-3 py-2 rounded-xl hover:bg-opacity-95 cursor-pointer transition flex items-center gap-1">
                                <span>＋</span> Tambah Lantai
                            </button>
                        </div>

                        <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-2xs">
                            <div class="bg-gray-50/70 px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">🛏️ Lantai 1</span>
                                <button type="button" class="text-[11px] font-bold text-amber-600 hover:underline cursor-pointer">＋ Tambah Tipe Kamar</button>
                            </div>

                            <div class="p-4 grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                                <div
                                    class="md:col-span-1 border-2 border-dashed border-gray-200 rounded-xl p-4 flex flex-col items-center justify-center text-center cursor-pointer hover:border-primary/50 transition h-full min-h-[140px] bg-gray-50/30">
                                    <span class="text-xl mb-1">📷</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Upload Foto</span>
                                    <input type="file" id="foto_kamar" name="foto_kamar" class="hidden">
                                </div>

                                <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div class="sm:col-span-1">
                                        <label for="tipe_kamar" class="block text-[11px] font-semibold text-gray-400 mb-0.5">Tipe Kamar</label>
                                        <input type="text" id="tipe_kamar" name="tipe_kamar" placeholder="Standard Non-AC"
                                            class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="status" class="block text-[11px] font-semibold text-gray-400 mb-0.5">Status Ketersediaan</label>
                                        <select id="status" name="status"
                                            class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-primary bg-white">
                                            <option>Tersedia (2 Kamar)</option>
                                            <option>Penuh</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="harga_bulan" class="block text-[11px] font-semibold text-gray-400 mb-0.5">Harga / Bulan</label>
                                        <input type="text" id="harga_bulan" name="harga_bulan" placeholder="Rp 850.000"
                                            class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>
                                    <div>
                                        <label for="harga_tahun" class="block text-[11px] font-semibold text-gray-400 mb-0.5">Harga / Tahun (Opsional)</label>
                                        <input type="text" id="harga_tahun" name="harga_tahun" placeholder="Rp Opsional"
                                            class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="deskripsi_kamar" class="block text-[11px] font-semibold text-gray-400 mb-0.5">Deskripsi Tambahan</label>
                                        <input type="text" id="deskripsi_kamar" name="deskripsi_kamar"
                                            placeholder="Jendela menghadap taman depan"
                                            class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="bg-[#807300] hover:bg-[#665c00] text-white text-xs font-bold py-3 px-6 rounded-xl flex items-center gap-2 cursor-pointer transition shadow-md transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Tambahkan Kamar</span>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div id="modal-fasilitas"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-xs p-4">
        <div
            class="bg-white w-full max-w-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform transition-all scale-95 duration-200">
            <div class="p-5 border-b border-gray-50">
                <h3 class="text-sm font-bold text-gray-900">Tambah Fasilitas Baru</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Ketik fasilitas umum kost yang ingin disediakan.</p>
            </div>
            <div class="p-5">
                <label for="input-fasilitas-baru" class="sr-only">Nama Fasilitas Baru</label>
                <input type="text" id="input-fasilitas-baru" placeholder="Contoh: 🧺 Mesin Cuci"
                    class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary">
            </div>
            <div class="p-4 bg-gray-50 flex justify-end gap-2">
                <button type="button" onclick="closeFasilitasModal()"
                    class="text-xs font-bold text-gray-500 hover:text-gray-700 px-4 py-2 cursor-pointer transition">
                    Batal
                </button>
                <button type="button" onclick="submitFasilitasBaru()"
                    class="bg-[#071931] text-white text-xs font-bold px-4 py-2 rounded-xl hover:bg-opacity-95 cursor-pointer transition shadow-xs">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal-fasilitas');
        const inputFasilitas = document.getElementById('input-fasilitas-baru');
        const wrapperFasilitas = document.getElementById('wrapper-fasilitas');

        function openFasilitasModal() {
            modal.classList.remove('hidden');
            inputFasilitas.focus();
        }

        function closeFasilitasModal() {
            modal.classList.add('hidden');
            inputFasilitas.value = '';
        }

        function submitFasilitasBaru() {
            const value = inputFasilitas.value.trim();

            if (value !== '') {
                const newBadge = document.createElement('span');
                newBadge.className =
                    "inline-flex items-center gap-1 bg-blue-50 text-blue-600 text-xs font-medium px-3 py-1.5 rounded-lg border border-blue-100 animate-fade-in";
                newBadge.innerHTML = value;

                wrapperFasilitas.appendChild(newBadge);
                closeFasilitasModal();
            }
        }

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFasilitasModal();
            }
        });
    </script>
@endsection
