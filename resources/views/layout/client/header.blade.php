<header class="bg-white shadow-sm">
    <div class="container mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
        <!-- Left: Logo + Nav -->
        <div class="flex items-center space-x-8">
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold text-blue-600 hover:text-blue-700">
                MyLogo
            </a>
            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">
                    Bài viết
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">
                    Hỏi đáp
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">
                    Tài liệu
                </a>
            </nav>
        </div>

        <!-- Right: Search + Authentication -->
        <div class="flex items-center space-x-6">
            <!-- Search -->
            <form action="#" method="GET" class="relative hidden lg:block">
                <input
                    type="text"
                    name="q"
                    placeholder="Tìm kiếm..."
                    class="pl-4 pr-10 py-2 w-64 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <button
                    type="submit"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 focus:outline-none"
                    aria-label="Search">
                    <svg
                        class="w-5 h-5 text-gray-500 hover:text-blue-600 transition"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                    </svg>
                </button>
            </form>


            <!-- Authentication Links -->
            <div class="flex items-center">
                @guest
                <a href="{{ url('auth/google') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                    Đăng nhập
                </a>
                @else
                <x-dropdown align="right" class="min-w-[10rem]">
                    <x-slot name="trigger">
                        <button class="flex items-center focus:outline-none">
                            @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar"
                                class="h-8 w-8 rounded-full object-cover">
                            @else
                            <div
                                class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            @endif
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <span class="block text-gray-800 font-semibold truncate">
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        <a href="{{ route('create.post') }}" class="block px-4 py-2 text-gray-800 hover:text-blue-600 transition">
                            Tạo bài viết
                        </a>
                    </x-slot>
                </x-dropdown>
                @endguest
            </div>
        </div>
    </div>
</header>