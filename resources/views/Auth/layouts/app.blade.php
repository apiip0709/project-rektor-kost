<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - Rektor-Kost</title>
    <!-- Masukkan asset Tailwind CSS Anda di sini -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col justify-between antialiased">

    <!-- HEADER / LOGO ATAS -->
    <header class="pt-12 pb-4 flex justify-center">
        <div
            class="w-24 h-12 bg-gray-300 rounded-lg flex items-center justify-center text-xs font-bold text-gray-600 tracking-wider">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Rektor-Kost" class="h-full w-full object-contain">
        </div>
    </header>

    <!-- KONTEN UTAMA (Tempat Card Login / Daftar Masuk) -->
    <main class="flex-1 flex items-center justify-center p-4">
        @yield('content')
    </main>

    <!-- FOOTER BAWAH -->
    <footer class="bg-primary text-white py-8 mt-4">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-lg font-bold mb-4">Rektor-Kost</h2>
            <div class="flex flex-wrap justify-center gap-6 text-xs text-gray-300 mb-6">
                <a href="#" class="hover:text-secondary transition">Tentang Kami</a>
                <a href="#" class="hover:text-secondary transition">Pusat Bantuan</a>
                <a href="#" class="hover:text-secondary transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-secondary transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-secondary transition">Hubungi Kami</a>
            </div>
            <p class="text-xs text-gray-400">
                &copy; {{ date('Y') }} <span class="text-secondary font-medium">Rektor-Kost</span>. Semua Hak
                Dilindungi.
            </p>
        </div>
    </footer>

</body>

</html>
