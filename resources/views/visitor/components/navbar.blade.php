<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <a href="#" class="text-xl font-bold text-primary flex items-center gap-1">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-auto">
                <span>Rektor-Kost</span>
            </a>
            <div class="hidden md:flex items-center gap-4 text-sm font-medium">
                <a href="#" class="text-primary border-b-2 border-primary pb-1">Cari Properti</a>
            </div>
        </div>

        <div class="hidden lg:flex items-center relative w-96">
            <input type="text" placeholder="Cari area, kampus, stasiun..."
                class="w-full bg-gray-100 text-sm pl-10 pr-4 py-2 rounded-lg border border-transparent focus:outline-none focus:border-primary">
            <span class="absolute left-3 text-gray-400">🔍</span>
        </div>

        <div class="flex items-center gap-4">
            <button class="text-gray-600 hover:text-primary relative p-1">
                🔔 <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            @guest
                <a href="{{ route('register') }}" class="text-sm font-medium text-primary hover:underline">Daftar</a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-opacity-95 transition-all shadow-xs hover:shadow-md transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span>Masuk</span>
                </a>
            @endguest

            @auth
                <span class="text-sm text-gray-600 hidden sm:inline mr-2">Halo, <b>{{ Auth::user()->name }}</b></span>

                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="inline"
                    onsubmit="showLogoutLoading()">
                    @csrf
                    <button type="submit" id="logoutBtn"
                        class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg
                               transition-all duration-200 ease-in-out cursor-pointer disabled:opacity-75 disabled:cursor-wait
                               hover:bg-red-700 hover:shadow-md
                               active:scale-95 active:bg-red-800
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        <span id="logoutBtnContent" class="inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <span>Keluar</span>
                        </span>

                        <span id="logoutBtnLoading" class="hidden items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>Memuat...</span>
                        </span>

                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<script>
    function showLogoutLoading() {
        const btn = document.getElementById('logoutBtn');
        const content = document.getElementById('logoutBtnContent');
        const loading = document.getElementById('logoutBtnLoading');

        content.classList.remove('inline-flex');
        content.classList.add('hidden');
        loading.classList.remove('hidden');
        
        loading.classList.add('inline-flex');
        btn.setAttribute('disabled', 'true');
    }
</script>
