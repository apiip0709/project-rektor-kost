<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <a href="#" class="text-xl font-bold text-primary flex items-center gap-1">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-auto">
                <span">Rektor-Kost</span>
            </a>
            <div class="hidden md:flex items-center gap-4 text-sm font-medium">
                <a href="#" class="text-primary border-b-2 border-primary pb-1">Cari Properti</a>
                <a href="#" class="text-gray-500 hover:text-primary">Kelola</a>
                <a href="#" class="text-gray-500 hover:text-primary">Dashboard</a>
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
            <a href="#" class="text-sm font-medium text-primary hover:underline">Daftar</a>
            <a href="#" class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-opacity-90 transition">
                Masuk
            </a>
        </div>
    </div>
</nav>
