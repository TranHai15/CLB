<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    <style>
        :root {
            --font-primary: 'Inter', sans-serif;
            --font-secondary: 'Fira Code', monospace;
        }

        body {
            font-family: var(--font-primary);
        }

        .font-mono {
            font-family: var(--font-secondary);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50" data-auth="{{ Auth::check() ? 'true' : 'false' }}" data-login-url="{{ route('login') }}">
    <div x-data="{ showHeader: true, lastScrollPosition: 0 }"
        @scroll.window="
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            showHeader = currentScrollPosition < lastScrollPosition || currentScrollPosition < 50;
            lastScrollPosition = currentScrollPosition <= 0 ? 0 : currentScrollPosition;
         "
        class="fixed top-0 left-0 right-0 z-50 transition-transform duration-300"
        :class="{ 'translate-y-0': showHeader, '-translate-y-full': !showHeader }">
        @include('client.layout.header')
    </div>
    <div class="h-[70px]"></div>
    <!-- Page Content -->
    <main class="">
        <div class="">
            @yield('content')
        </div>
    </main>

    @include('client.layout.footer')
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>