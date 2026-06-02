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
        <div class="w-24 h-12 bg-gray-300 rounded-lg flex items-center justify-center text-xs font-bold text-gray-600 tracking-wider">
              <img src="{{ asset('img/logo.png') }}" alt="Logo Rektor-Kost" class="h-full w-full object-contain">
          </div>
    </header>

    <!-- KONTEN UTAMA (Tempat Card Login / Daftar Masuk) -->
    <main class="flex-1 flex items-center justify-center p-4">
        @yield('content')
    </main>

    <!-- FOOTER BAWAH -->
    <footer class="py-6 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} Rektor-Kost. All rights reserved.
        </div>
    </footer>

</body>
</html>
