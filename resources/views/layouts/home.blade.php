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
</head>

<body class="bg-gray-50 text-gray-800">


    {{-- Header --}}


    {{-- Main Content --}}
    <main class="container px-4 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}

</body>
@yield('js')

</html>