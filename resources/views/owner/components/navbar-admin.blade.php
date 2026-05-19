<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between relative">

        <div class="flex items-center gap-6">
            <a href="#" class="text-xl font-bold text-primary flex items-center gap-1">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-auto">
                <span>Rektor-Kost</span>
            </a>
        </div>

        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden md:flex items-center">
            <a href="#"
                class="text-base font-bold text-primary border-b-2 border-primary pb-1 tracking-wide uppercase">
                Dashboard
            </a>
        </div>

        <div class="flex items-center gap-4">
            <a href="#"
                class="inline-flex items-center gap-2 bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-opacity-95 transition-all shadow-xs hover:shadow-md transform hover:-translate-y-0.5">
                <span>Logout</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H8.25" />
                </svg>
            </a>
        </div>
    </div>
</nav>
