<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rektor-Kost | Superadmin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-[#F8FAFC] text-slate-800 antialiased min-h-screen flex flex-col">

    <div class="flex flex-1 min-h-screen relative">

        @include('admin.components.sidebar-superadmin')

        <div class="flex-1 flex flex-col min-w-0 ml-16 lg:ml-64 transition-all duration-300 ease-in-out">

            @include('admin.components.navbar-superadmin')

            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>

            @include('admin.components.footer-superadmin')

        </div>
    </div>

</body>

</html>
