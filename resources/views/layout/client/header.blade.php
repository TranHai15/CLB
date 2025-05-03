<header class="bg-white shadow-sm">
    <div class="container  flex flex-wrap items-center justify-between py-4 px-4  max-w-7xl mx-auto">
        <!-- Logo -->
        <a href="/" class="text-2xl font-bold text-blue-600">MyLogo</a>

        <!-- Navigation -->
        <nav class="flex flex-wrap items-center space-x-6">
            <a href="#" class="text-gray-700 hover:text-blue-600">Bài viết</a>
            <a href="#" class="text-gray-700 hover:text-blue-600">Hỏi đáp</a>
        </nav>

        <!-- Search Form -->
        <form action="#" method="GET" class="relative hidden md:block">
            <input type="text" name="q" placeholder="Tìm kiếm..." class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
            </svg>
        </form>

        <!-- Authentication Links -->
        <div class="flex items-center space-x-4">
            @guest
            <a href="/login" class="flex items-center text-gray-700 hover:text-blue-600">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                Đăng nhập
            </a>
            <a href="/register" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Đăng ký
            </a>
            @else
            <span class="text-gray-700">Xin chào, {{ Auth::user()->name }}</span>
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit" class="flex items-center text-gray-700 hover:text-red-600 ml-4">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Đăng xuất
                </button>
            </form>
            @endguest
        </div>
    </div>
</header>