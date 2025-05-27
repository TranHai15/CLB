@extends('layouts.home')
<style>
    .post-title {
        color: white !important;
    }

    .post-input {
        background: #1f2937 !important;
    }

    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        /* 12px */
        border: 1px solid transparent;
    }
</style>
@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 ">
        <!-- Main Content -->
        <div class="lg:col-span-3  ">
            <div class="post-card  rounded-lg shadow-lg p-6">
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
                    <select id="dateFilter" class="pl-4 pr-8 py-2 border post-input  border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả thời gian</option>
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                    </select>

                    <select id="statusFilter" class="pl-4 pr-8 py-2 border post-input border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="unread">Chưa đọc</option>
                        <option value="read">Đã đọc</option>
                    </select>

                    <select id="typeFilter" class="pl-4 pr-8 py-2 border post-input border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả loại</option>
                        <option value="answer">Câu trả lời</option>
                        <option value="comment">Bình luận</option>
                        <option value="like">Thích</option>
                        <option value="mention">Đề cập</option>
                    </select>
                </div>

                <!-- Notifications List -->
                <div class="space-y-4">
                    @forelse ($notifications as $notification)
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition {{ $notification['read'] ? '' : 'bg-blue-50' }}">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $notification->sender->avatar_url }}"
                                    alt="{{ $notification->sender->name }}"
                                    class="w-10 h-10 rounded-full">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium">{{ $notification->sender->name }}</span>
                                        <span class="text-gray-500">{{ $notification->type }}</span>

                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-500">
                                            {{ $notification->created_at->format('d/m/Y H:i') }}
                                        </span>
                                        @if(!$notification['read'])
                                        <button class="text-sm text-blue-600 hover:text-blue-800 mark-read"
                                            data-id="{{ $notification->id }}">
                                            Đánh dấu đã đọc
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @if($notification->content)
                                <p class="mt-2 text-gray-600">{{ $notification->content }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-300">Không có thông báo nào</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Hiện tại chưa có thông báo nào.
                        </p>
                    </div>
                    @endforelse


                </div>

                <!-- Pagination -->

            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 ">
            <div class="post-card  rounded-lg shadow-lg p-6">
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