<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Technician Portal - Rektor-Kost' }}</title>
    <!-- FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar di sebelah kiri -->
        @include('teknisi.components.sidebar-teknisi')

        <!-- Area Konten Utama di sebelah kanan -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <!-- Navbar / Header atas -->
            @include('teknisi.components.navbar-teknisi')

            <!-- Konten Halaman -->
            <main class="p-8 flex-1">
                @yield('content')
            </main>

            <!-- Footer di bagian paling bawah konten kanan -->
            @include('teknisi.components.footer-teknisi')

        </div>
    </div>

</body>

</html>
