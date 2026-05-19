<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Rektor-Kost' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-neutral font-sans min-h-screen flex flex-col">

    @include('visitor.components.navbar')

    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>

    @include('visitor.components.footer')

</body>
</html>
