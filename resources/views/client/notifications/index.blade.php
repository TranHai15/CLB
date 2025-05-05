@extends('layouts.home')

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Thông báo</h2>
                    <div class="flex items-center gap-4">
                        <button class="text-sm text-gray-600 hover:text-blue-600" id="markAllRead">
                            Đánh dấu tất cả đã đọc
                        </button>
                        <button class="text-sm text-gray-600 hover:text-blue-600" id="clearAll">
                            Xóa tất cả
                        </button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <select id="dateFilter" class="pl-4 pr-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả thời gian</option>
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                    </select>

                    <select id="statusFilter" class="pl-4 pr-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="unread">Chưa đọc</option>
                        <option value="read">Đã đọc</option>
                    </select>

                    <select id="typeFilter" class="pl-4 pr-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả loại</option>
                        <option value="answer">Câu trả lời</option>
                        <option value="comment">Bình luận</option>
                        <option value="like">Thích</option>
                        <option value="mention">Đề cập</option>
                    </select>
                </div>

                <!-- Notifications List -->
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition {{ $notification['read'] ? '' : 'bg-blue-50' }}">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $notification['sender']['avatar'] }}"
                                    alt="{{ $notification['sender']['name'] }}"
                                    class="w-10 h-10 rounded-full">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium">{{ $notification['sender']['name'] }}</span>
                                        <span class="text-gray-500">{{ $notification['action'] }}</span>
                                        <a href="{{ $notification['link'] }}" class="text-blue-600 hover:underline">
                                            {{ $notification['target'] }}
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                        </span>
                                        @if(!$notification['read'])
                                        <button class="text-sm text-blue-600 hover:text-blue-800 mark-read"
                                            data-id="{{ $notification['id'] }}">
                                            Đánh dấu đã đọc
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @if($notification['content'])
                                <p class="mt-2 text-gray-600">{{ $notification['content'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->

            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4">Thống kê</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tổng số thông báo</span>
                        <span class="font-medium">{{ $totalNotifications }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Chưa đọc</span>
                        <span class="font-medium text-blue-600">{{ $unreadCount }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Đã đọc</span>
                        <span class="font-medium text-green-600">{{ $readCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark as read
        document.querySelectorAll('.mark-read').forEach(button => {
            button.addEventListener('click', function() {
                const notificationId = this.dataset.id;
                // Add your mark as read logic here
                this.closest('.border').classList.remove('bg-blue-50');
                this.remove();
            });
        });

        // Mark all as read
        document.getElementById('markAllRead').addEventListener('click', function() {
            // Add your mark all as read logic here
            document.querySelectorAll('.bg-blue-50').forEach(notification => {
                notification.classList.remove('bg-blue-50');
            });
            document.querySelectorAll('.mark-read').forEach(button => {
                button.remove();
            });
        });

        // Clear all
        document.getElementById('clearAll').addEventListener('click', function() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả thông báo?')) {
                // Add your clear all logic here
                document.querySelector('.space-y-4').innerHTML = '';
            }
        });

        // Filters
        ['dateFilter', 'statusFilter', 'typeFilter'].forEach(filterId => {
            document.getElementById(filterId).addEventListener('change', function() {
                // Add your filter logic here
            });
        });
    });
</script>
@endpush
@endsection