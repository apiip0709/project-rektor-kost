<header class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between sticky top-0 z-10">
    <!-- Kiri: Tombol Hamburger (Mobile) & Search Bar -->
    <div class="flex items-center gap-3">
        <!-- Tombol Hamburger untuk memanggil fungsi toggleSidebar() -->
        <button onclick="toggleSidebar()"
            class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none p-1 rounded-lg hover:bg-gray-100 transition">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
    </div>

    <!-- Top Right Icon & Profile -->
    <div class="flex items-center gap-4">
        <!-- Notifikasi -->
        <button class="relative text-gray-600 hover:text-gray-900 focus:outline-none">
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            <i class="fa-regular fa-bell text-lg"></i>
        </button>

        <!-- Profil & Tombol Logout -->
        <div class="flex items-center gap-3 border-l pl-4 border-gray-200">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=faces"
                alt="Avatar" class="w-9 h-9 rounded-full object-cover">

            <!-- Form Logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-xs text-gray-500 hover:text-red-600 font-medium transition" title="Keluar">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </div>
</header>
