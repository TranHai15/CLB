@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Chi tiết bài đăng</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.posts.index') }}" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                <svg class="w-4 h-4 fill-current text-gray-400 shrink-0" viewBox="0 0 16 16">
                    <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                </svg>
                <span class="ml-2">Quay lại</span>
            </a>
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                </svg>
                <span class="ml-2">Chỉnh sửa</span>
            </a>
        </div>
    </div>

    <!-- Post Details -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <div class="p-6">
            <!-- Title and Status -->
            <div class="mb-6">
                <div class="flex flex-wrap items-center justify-between mb-2">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $post->title }}</h2>
                    <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                        @if($post->type === 'post')
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                            Bài viết
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800">
                            Câu hỏi
                        </span>
                        @endif

                        @if($post->status === 'published')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                            Đã xuất bản
                        </span>
                        @elseif($post->status === 'draft')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                            Nháp
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                            Đã lưu trữ
                        </span>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-500">Slug: {{ $post->slug }}</p>
            </div>

            <!-- Featured Image -->
            @if($post->image)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hình ảnh</h3>
                <div class="max-w-md rounded-md overflow-hidden border border-gray-200">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-auto">
                </div>
            </div>
            @endif

            <!-- Content -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nội dung</h3>
                <div class="prose max-w-none bg-gray-50 p-4 rounded-md border border-gray-200">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Meta Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Classification Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-3">Phân loại</h3>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Danh mục</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                {{ $post->category ? $post->category->name : 'Không có' }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Thẻ</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                @if($post->tags->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($post->tags as $tag)
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800">
                                        {{ $tag->name }}
                                    </span>
                                    @endforeach
                                </div>
                                @else
                                Không có
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Stats Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-3">Thống kê</h3>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Lượt xem</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $post->views }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Lượt thích</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $post->likes }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Author Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-3">Tác giả</h3>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Tạo bởi</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                @if($post->creator)
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full mr-2 overflow-hidden">
                                        <img src="{{ $post->creator->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $post->creator->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span>{{ $post->creator->name }}</span>
                                </div>
                                @else
                                Không có
                                @endif
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Cập nhật bởi</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                @if($post->updater)
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full mr-2 overflow-hidden">
                                        <img src="{{ $post->updater->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $post->updater->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span>{{ $post->updater->name }}</span>
                                </div>
                                @else
                                Không có
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-3">Thông tin hệ thống</h3>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">ID</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $post->id }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $post->created_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Cập nhật lần cuối</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $post->updated_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 border-t pt-6 flex items-center justify-between">
                <div>
                    <form action="{{ route('admin.posts.toggle-status', $post) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                            @if($post->status === 'published')
                            <span>Lưu trữ bài đăng</span>
                            @else
                            <span>Xuất bản bài đăng</span>
                            @endif
                        </button>
                    </form>
                </div>
                <div>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn border-red-200 hover:border-red-300 text-red-600">
                            <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                            </svg>
                            <span>Xóa bài đăng</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection