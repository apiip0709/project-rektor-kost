@extends('admin.layouts.superadmin')

@section('content')
    <div class="flex flex-col gap-6">
        @if (session('success'))
            <div id="success-alert"
                class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm flex justify-between items-center animate-in fade-in slide-in-from-top-2 duration-300">
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

        <div class="mb-2">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Pemilik</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola pendaftaran dan status akun pemilik.</p>
        </div>

        {{-- Bagian Menunggu Verifikasi --}}
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-800">Menunggu Verifikasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($pendingOwners as $owner)
                    <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm flex flex-col gap-3">
                        <div class="flex justify-between items-start">
                            <span
                                class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold uppercase rounded-lg">Menunggu</span>
                            <span class="text-xs text-slate-400 font-mono">{{ $owner->owner_id }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $owner->user->name }}</h3>
                            <p class="text-xs text-slate-500">{{ $owner->user->email }}</p>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <form action="{{ route('superadmin.owner.updateStatus', $owner->owner_id) }}" method="POST"
                                class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="akun" value="aktif">
                                <button
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2 rounded-lg transition cursor-pointer">Terima</button>
                            </form>
                            <form action="{{ route('superadmin.owner.updateStatus', $owner->owner_id) }}" method="POST"
                                class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="akun" value="nonaktif">
                                <button
                                    class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-lg transition cursor-pointer">Tolak</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full p-6 text-center text-slate-400 border border-dashed rounded-xl bg-slate-50/50">
                        Tidak ada permintaan verifikasi.</div>
                @endforelse
            </div>
        </div>

        {{-- Tabel Pengguna --}}
        <div id="tabel-wrapper" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div
                class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/50">
                <h2 class="font-bold text-slate-800 text-lg">Pengguna Terdaftar</h2>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:w-72">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i
                                class="fa-solid fa-magnifying-glass text-sm"></i></span>
                        <input type="text" id="search-input" value="{{ $keyword ?? '' }}"
                            placeholder="Cari ID, Nama, Status..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-4 text-sm outline-none focus:border-slate-400 transition-all">
                    </div>
                    <button type="button" onclick="userModal.showModal()"
                        class="flex items-center gap-2 rounded-xl bg-[#0F172A] px-4 py-2 text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-sm whitespace-nowrap cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i> Tambah Akun
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="main-table" class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-400 text-xs font-bold uppercase">
                        <tr>
                            <th class="py-3 px-4">ID Owner</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Status Akun</th>
                            <th class="py-3 px-4">Status Langganan</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="divide-y divide-slate-100">
                        @foreach ($owners as $owner)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-4 font-mono text-xs text-slate-500">{{ $owner->owner_id }}</td>
                                <td class="py-4 px-4 font-bold text-slate-900">{{ $owner->user->name }}</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-2 py-1 text-[10px] font-bold rounded-lg {{ $owner->akun == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ strtoupper($owner->akun) }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="px-2 py-1 text-[10px] font-bold rounded-lg {{ $owner->status == 'premium' ? 'bg-purple-100 text-purple-700' : ($owner->status == 'gold' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">{{ strtoupper($owner->status ?? 'SILVER') }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('superadmin.owner.show', $owner->owner_id) }}"
                                            class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('superadmin.owner.edit', $owner->owner_id) }}"
                                            class="text-amber-600 hover:text-amber-800 transition-colors" title="Edit"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <button type="button"
                                            onclick="openStatusModal('{{ route('superadmin.owner.updateStatus', $owner->owner_id) }}', '{{ $owner->akun === 'nonaktif' ? 'aktif' : 'nonaktif' }}')"
                                            class="transition-colors cursor-pointer {{ $owner->akun === 'nonaktif' ? 'text-emerald-600 hover:text-emerald-800' : 'text-red-600 hover:text-red-800' }}"><i
                                                class="fa-solid {{ $owner->akun === 'nonaktif' ? 'fa-circle-check' : 'fa-ban' }}"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals & Scripts --}}
    <div id="statusModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 animate-in fade-in zoom-in duration-200">
            <h3 id="modalTitle" class="text-lg font-bold text-slate-900">Konfirmasi</h3>
            <p id="modalDesc" class="text-slate-600 mt-2 text-sm"></p>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeStatusModal()"
                    class="flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg cursor-pointer text-sm font-bold text-slate-700 transition">Batal</button>
                <form id="statusForm" method="POST" class="flex-1">
                    @csrf @method('PUT')
                    <input type="hidden" id="statusInput" name="akun" value="">
                    <button type="submit" id="modalBtn"
                        class="w-full px-4 py-2 rounded-lg cursor-pointer text-sm font-bold text-white transition"></button>
                </form>
            </div>
        </div>
    </div>

    <dialog id="userModal"
        class="p-0 rounded-2xl shadow-xl w-full max-w-lg backdrop:bg-slate-900/50 fixed inset-0 m-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg">Pilih Pengguna</h3>
                <button onclick="userModal.close()" class="text-slate-400 hover:text-slate-600 cursor-pointer"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <input type="text" id="search-user-modal" placeholder="Cari ID atau Email..."
                class="w-full rounded-xl border border-slate-200 py-2 px-4 text-sm mb-4 outline-none focus:border-slate-400">
            <div id="user-list" class="max-h-80 overflow-y-auto space-y-2">
                @foreach ($users as $user)
                    <div class="flex justify-between items-center p-3 border rounded-xl hover:bg-slate-50">
                        <div>
                            <p class="font-bold text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->user_id }} |
                                {{ $user->register_method === 'whatsapp' ? $user->phone : $user->email }}</p>
                        </div>
                        <a href="{{ route('superadmin.owner.create', ['user_id' => $user->user_id]) }}"
                            class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1 rounded-lg hover:bg-blue-700 cursor-pointer block text-center no-underline">Jadikan
                            Owner</a>
                    </div>
                @endforeach
            </div>
        </div>
    </dialog>

    <script>
        let debounceTimer;

        // Live Search dengan Event Delegation
        document.addEventListener('input', function(e) {
            if (e.target && e.target.id === 'search-input') {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetch(
                            `{{ route('superadmin.owner.index') }}?search=${encodeURIComponent(e.target.value)}`)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newBody = doc.getElementById('table-body');
                            const currentBody = document.getElementById('table-body');
                            if (newBody && currentBody) {
                                currentBody.innerHTML = newBody.innerHTML;
                            }
                        });
                }, 300);
            }
        });

        // Modal Status
        function openStatusModal(url, type) {
            const form = document.getElementById('statusForm');
            const btn = document.getElementById('modalBtn');
            form.action = url;
            document.getElementById('statusInput').value = type;
            document.getElementById('modalTitle').innerText = type === 'aktif' ? 'Konfirmasi Aktifkan' :
                'Konfirmasi Nonaktif';
            document.getElementById('modalDesc').innerText =
                `Apakah Anda yakin ingin ${type === 'aktif' ? 'mengaktifkan' : 'menonaktifkan'} akun pemilik ini?`;
            btn.innerText = type === 'aktif' ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan';
            btn.className =
                `w-full px-4 py-2 rounded-lg cursor-pointer text-sm font-bold text-white transition ${type === 'aktif' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-red-600 hover:bg-red-700'}`;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        // Search Modal
        document.getElementById('search-user-modal').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll('#user-list > div').forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(filter) ? 'flex' : 'none';
            });
        });
    </script>
@endsection
