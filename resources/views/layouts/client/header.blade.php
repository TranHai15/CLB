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
</div>
