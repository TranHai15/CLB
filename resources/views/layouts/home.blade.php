<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Website')</title>

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    {{-- Nơi view con thêm CSS --}}
    @yield('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">


    {{-- Header --}}
    @include('layout.client.header')

    {{-- Main Content --}}
    <main class="px-4 py-8 min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layout.client.footer')

</body>
@yield('js')

</html>