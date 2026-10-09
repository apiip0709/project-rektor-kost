<!-- Overlay Gelap saat Sidebar Terbuka di HP -->
<div id="sidebar-overlay" onclick="toggleSidebar()"
    class="fixed inset-0 bg-gray-900/50 z-40 hidden md:hidden transition-opacity duration-300"></div>

<!-- Sidebar Modern & Responsif -->
<aside id="sidebar-teknisi"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 flex flex-col justify-between transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out shadow-2xl md:shadow-none">
    <div>
        <!-- Logo Brand & Tombol Close Mobile -->
        <div class="p-6 flex items-center justify-between border-b border-gray-100 md:border-none">
            <div>
                <h1 class="text-xl font-black tracking-tight text-gray-900">Rektor-Kost</h1>
                <p class="text-xs text-indigo-600 font-semibold mt-0.5 tracking-wide uppercase">Technician Portal</p>
            </div>
            <!-- Tombol Tutup untuk HP -->
            <button onclick="toggleSidebar()"
                class="md:hidden text-gray-400 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigasi Menu -->
        <nav class="mt-4 px-4 space-y-1.5">
            <!-- Tautan ke Dashboard Teknisi -->
            <a href="{{ route('teknisi.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('teknisi.dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-xs' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition-all group">
                <span
                    class="w-8 h-8 rounded-lg {{ request()->routeIs('teknisi.dashboard') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }} flex items-center justify-center transition">
                    <i class="fa-solid fa-table-columns text-xs"></i>
                </span>
                <span>Dashboard</span>
            </a>

            <!-- Tautan ke Kelola Kost -->
            <a href="{{ route('teknisi.kost.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('teknisi.kost.index') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-xs' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition-all group">
                <span
                    class="w-8 h-8 rounded-lg {{ request()->routeIs('teknisi.kost.index') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }} flex items-center justify-center transition">
                    <i class="fa-solid fa-store text-xs"></i>
                </span>
                <span>Kelola Kost</span>
            </a>

            <!-- Tautan ke Tambah Kost -->
            <a href="{{ route('teknisi.kost.create') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('teknisi.kost.create') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-xs' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition-all group">
                <span
                    class="w-8 h-8 rounded-lg {{ request()->routeIs('teknisi.kost.create') ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }} flex items-center justify-center transition">
                    <i class="fa-solid fa-plus-circle text-xs"></i>
                </span>
                <span>Tambah Kost</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Bantuan & Info -->
    <div class="p-4 border-t border-gray-100">
        <a href="#"
            class="flex items-center justify-center gap-2 w-full py-3 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 bg-gray-50 hover:bg-gray-100 hover:border-gray-300 shadow-xs transition">
            <i class="fa-solid fa-circle-question text-indigo-600"></i> Pusat Bantuan
        </a>
    </div>
</aside>

<!-- Script JavaScript untuk Toggle Sidebar di HP -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar-teknisi');
        const overlay = document.getElementById('sidebar-overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
