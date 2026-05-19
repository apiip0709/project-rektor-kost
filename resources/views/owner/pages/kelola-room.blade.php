@extends('owner.layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 p-2">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Status Kamar (Remote)</h1>
                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('dashboard') }}"
                        class="text-xs text-primary font-bold hover:underline inline-flex items-center gap-1">
                        ← Dashboard
                    </a>
                    <span class="text-gray-300">/</span>
                    <span>Update ketersediaan kamar dengan cepat dan mudah.</span>
                </p>
            </div>
        </div>

        <div class="space-y-4">

            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Kamar 101</h3>
                    <p class="text-xs text-gray-400 mt-1">Rp 1.500.000 / bln</p>
                </div>
                <div>
                    <button onclick="toggleStatus(this)"
                        class="status-btn inline-flex items-center justify-center gap-1.5 bg-[#10b981] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-xs hover:cursor-pointer hover:shadow-lg hover:-translate-y-0.5 w-full sm:w-40 uppercase tracking-wide transition-all active:scale-95">
                        ✓ Tersedia
                    </button>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Kamar 102</h3>
                    <p class="text-xs text-gray-400 mt-1">Rp 1.500.000 / bln</p>
                </div>
                <div>
                    <button onclick="toggleStatus(this)"
                        class="status-btn inline-flex items-center justify-center gap-1.5 bg-[#ef4444] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-xs hover:cursor-pointer hover:shadow-lg hover:-translate-y-0.5 w-full sm:w-40 uppercase tracking-wide transition-all active:scale-95">
                        🛇 Penuh
                    </button>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Kamar 103</h3>
                    <p class="text-xs text-gray-400 mt-1">Rp 1.750.000 / bln</p>
                </div>
                <div>
                    <button onclick="toggleStatus(this)"
                        class="status-btn inline-flex items-center justify-center gap-1.5 bg-[#10b981] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-xs hover:cursor-pointer hover:shadow-lg hover:-translate-y-0.5 w-full sm:w-40 uppercase tracking-wide transition-all active:scale-95">
                        ✓ Tersedia
                    </button>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs hover:shadow-md transition flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Kamar 201 (VIP)</h3>
                    <p class="text-xs text-gray-400 mt-1">Rp 2.500.000 / bln</p>
                </div>
                <div>
                    <button onclick="toggleStatus(this)"
                        class="status-btn inline-flex items-center justify-center gap-1.5 bg-[#ef4444] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-xs hover:cursor-pointer hover:shadow-lg hover:-translate-y-0.5 w-full sm:w-40 uppercase tracking-wide transition-all active:scale-95">
                        🛇 Penuh
                    </button>
                </div>
            </div>

        </div>

        <div class="pt-4">
            <a href="/tambah-kamar"
                class="w-full bg-[#071931] hover:bg-[#0c294d] text-white text-sm font-bold py-4 px-6 rounded-xl flex items-center justify-center gap-2 transition shadow-md transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Kamar Kost</span>
            </a>
        </div>

    </div>

    <script>
        function toggleStatus(button) {
            if (button.classList.contains('bg-[#10b981]')) {
                button.classList.remove('bg-[#10b981]');
                button.classList.add('bg-[#ef4444]');
                button.innerHTML = '🛇 Penuh';
            } else {
                button.classList.remove('bg-[#ef4444]');
                button.classList.add('bg-[#10b981]');
                button.innerHTML = '✓ Tersedia';
            }
        }
    </script>
@endsection
