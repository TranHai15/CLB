<header class="bg-white shadow-sm">
    <div class="container mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
        <!-- Left: Logo + Nav -->
        <div class="flex items-center space-x-8">
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold text-blue-600 hover:text-blue-700">
                MyLogo
            </a>
            <!-- Navigation -->
            <nav class=" md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">
                    Bài viết
                </a>
                <a href="{{ route('questions.index') }}" class="text-gray-700 hover:text-blue-600 transition">
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
            <form action="#" method="GET" class="relative  lg:block">
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

            <!-- ... existing code ... -->
            <div class="flex items-center gap-4">
                <!-- Notification Icon -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-blue-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($unreadNotifications > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $unreadNotifications }}
                        </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="open"
                        @click.away="open = false"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold">Thông báo</h3>
                                <a href="{{ route('notifications') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                    Xem tất cả
                                </a>
                            </div>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @foreach($latestNotifications as $notification)
                            <a href="{{ $notification['link'] }}" class="block px-4 py-3 hover:bg-gray-50 transition {{ $notification['read'] ? '' : 'bg-blue-50' }}">
                                <div class="flex items-start gap-3">
                                    <img src="{{ $notification['sender']['avatar'] }}"
                                        alt="{{ $notification['sender']['name'] }}"
                                        class="w-8 h-8 rounded-full">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900 truncate">
                                            <span class="font-medium">{{ $notification['sender']['name'] }}</span>
                                            <span class="text-gray-500">{{ $notification['action'] }}</span>
                                            <span class="text-blue-600">{{ $notification['target'] }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- ... existing code ... -->
            </div>
            <!-- ... existing code ... -->
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