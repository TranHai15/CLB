<header class="bg-[var(--dark-card-bg)] shadow-lg sticky top-0 z-50 border-b border-gray-700/50">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <!-- Mobile Menu Toggle -->
        <div x-data="{ openMobile: false }" class="relative w-[52px] flex justify-center items-center">
            <button @click="openMobile = !openMobile" class="md:hidden text-gray-300 hover:text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div x-show="openMobile" x-transition class="md:hidden fixed right-0 bottom-0 top-[60px] left-0 w-full bg-white shadow-lg z-[99]">
                <nav class="flex flex-col space-y-2 px-4 py-4 bg-[#111827] text-[#f3f4f6] ">
                    <a href="{{ route('home') }}" class=" font-medium hover:text-[var(--primary-color)]">Bài viết</a>
                    <a href="{{ route('questions.index') }}" class=" font-medium hover:text-[var(--primary-color)]">Hỏi đáp</a>
                    <a href="#" class=" font-medium hover:text-[var(--primary-color)]">Tài liệu</a>
                    <a href="{{ route('meb') }}" class=" font-medium hover:text-[var(--primary-color)]">Thành viên</a>
                </nav>
            </div>
        </div>

        <!-- Logo -->
        <div>
            <a href="/" class="text-2xl font-bold text-[var(--primary-color)] hover:text-[var(--primary-hover-color)] transition-colors duration-200">
                BeeIT
            </a>
        </div>

        <!-- Navigation -->
        <div class="hidden lg:block">
            <nav class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-[var(--text-medium)] hover:text-[var(--primary-color)] transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-[var(--primary-color)] bg-gray-700/50' : '' }}">
                    Bài viết
                </a>
                <a href="{{ route('questions.index') }}" class="text-[var(--text-medium)] hover:text-[var(--primary-color)] transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('questions.index') || request()->routeIs('questions.create') ? 'text-[var(--primary-color)] bg-gray-700/50' : '' }}">
                    Hỏi đáp
                </a>
                <a href="#" class="text-[var(--text-medium)] hover:text-[var(--primary-color)] transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">
                    Tài liệu
                </a>
                <a href="{{ route('meb') }}" class="text-[var(--text-medium)] hover:text-[var(--primary-color)] transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('meb') ? 'text-[var(--primary-color)] bg-gray-700/50' : '' }}">
                    Thành Viên
                </a>
            </nav>
        </div>

        <!-- Search -->
        <div class="hidden lg:block">
            <form action="{{ route('home.search') }}" method="GET" class="relative hidden  lg:block m-0">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Tìm kiếm..."
                    class="pl-4 pr-10 py-2 w-64 bg-gray-700/50 border border-gray-600 text-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors duration-200 placeholder-gray-500 text-sm">
                <button
                    type="submit"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 focus:outline-none"
                    aria-label="Search">
                    <svg
                        class="w-5 h-5 text-gray-400 hover:text-[var(--primary-color)] transition-colors duration-200"
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
        </div>

        <div class="flex gap-4 items-center">
            <!-- Notifications (chỉ cho người dùng đã đăng nhập) -->
            <div class="hidden lg:block">
                @guest
                <!-- Không hiển thị thông báo cho khách -->
                @else
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-[var(--primary-color)] focus:outline-none rounded-full hover:bg-gray-700/50 transition-colors duration-200">
                        <span class="sr-only">View notifications</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute top-1 right-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $unreadNotifications }}
                        </span>
                        @endif
                    </button>
                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-80 sm:w-96 bg-[var(--dark-card-bg-hover)] rounded-lg shadow-xl border border-gray-700 py-1 z-50 origin-top-right">
                        <div class="px-4 py-3 border-b border-gray-700">
                            <div class="flex justify-between items-center">
                                <h3 class="text-base font-semibold text-gray-200">Thông báo</h3>
                                <a href="{{ route('notifications') }}" class="text-sm text-[var(--primary-color)] hover:text-[var(--primary-hover-color)]">
                                    Xem tất cả
                                </a>
                            </div>
                        </div>
                        <div class="max-h-96 overflow-y-auto custom-scrollbar">
                            @if(isset($latestNotifications) && count($latestNotifications))
                            @foreach($latestNotifications as $notification)
                            <a href="{{ $notification['link'] ?? '#' }}"
                                class="block px-4 py-3 hover:bg-gray-700/70 transition {{ $notification['read'] ? '' : 'bg-sky-800/30' }}">
                                <div class="flex items-start gap-3">
                                    <img src="{{ $notification->sender->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($notification->sender->name).'&background=4b5563&color=f3f4f6' }}"
                                        alt="{{ $notification->sender->name }}"
                                        class="w-10 h-10 rounded-full object-cover">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-300">
                                            <span class="font-medium text-gray-100">
                                                {{ $notification->sender->name }}</span>
                                            <span class="text-gray-400">{{ $notification->message ?? $notification->type }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <p class="px-4 py-6 text-center text-gray-500">Chưa có thông báo nào</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endguest
            </div>

            <!-- Authentication -->
            <div>
                @guest
                <a href="{{ url('auth/google') }}" class="flex items-center text-[var(--text-medium)] hover:text-[var(--primary-color)] transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="hidden sm:inline">Đăng nhập</span>
                </a>
                @else
                <x-dropdown align="right" class="min-w-[10rem]">
                    <x-slot name="trigger">
                        <button class="flex items-center focus:outline-none">
                            @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar"
                                class="h-8 w-8 rounded-full object-cover">
                            @else
                            <div
                                class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-medium">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            @endif
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <span class="block text-gray-800 font-semibold truncate">
                                {{ auth()->user()->name }}
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
                        <a href="{{ route('questions.create') }}" class="block px-4 py-2 text-gray-800 hover:text-blue-600 transition">
                            Tạo Câu Hỏi
                        </a>
                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('head-phong-nhan-su') || auth()->user()->hasRole('staff-phong-nhan-su'))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:text-blue-600 transition">
                            Vào Trang Quản Trị
                        </a>
                        @endif
                    </x-slot>
                </x-dropdown>
                @endguest
            </div>
        </div>
    </div>
</header>