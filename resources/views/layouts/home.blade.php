<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            --primary-color: #f59e0b;
            /* Amber-500 for Bee IT accent */
            --primary-hover-color: #d97706;
            /* Amber-600 */
            --secondary-color: #0ea5e9;
            /* Sky-500 */
            --dark-bg: #111827;
            /* Gray-900 */
            --dark-card-bg: #1f2937;
            /* Gray-800 */
            --dark-card-bg-hover: #374151;
            /* Gray-700 */
            --text-light: #f3f4f6;
            /* Gray-100 */
            --text-medium: #9ca3af;
            /* Gray-400 */
            --text-dark: #1f2937;
            /* Gray-800 */
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
        }

        /* phân trang */
        /* Pagination styling */
        .pagination {
            /* Add custom styles for pagination if needed, Tailwind usually handles this well */
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-link {
            color: var(--text-medium);
            background-color: var(--dark-card-bg);
            border: 1px solid #374151;
        }

        .pagination .page-link:hover {
            color: var(--text-light);
            background-color: var(--dark-card-bg-hover);
            border-color: var(--primary-color);
        }

        /* bgc của layout */
        .main-content-area {
            background-color: var(--dark-bg);
        }
    </style>
    {!! SEOTools::generate() !!}

</head>

<body class="font-sans antialiased bg-gray-50">
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
    <div class="h-[60px]"></div>
    <!-- Page Content -->
    <main class="main-content-area">
        <div>
            @yield('content')
        </div>
    </main>

    @include('client.layout.footer')
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>