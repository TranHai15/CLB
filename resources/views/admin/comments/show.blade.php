@extends('layouts.admin')

@section('title', 'Chi tiết bình luận')

@section('content')
<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Chi tiết bình luận</h1>
        <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-800">Bình luận #{{ $comment->id }}</h2>
            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('head-phong-truyen-thong') || auth()->user()->hasRole('staff-phong-truyen-thong'))
            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa bình luận
                </button>
            </form>
            @endif
        </div>
        <div class="p-6">
            <dl>
                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Mã bình luận:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">{{ $comment->id }}</dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Bài viết:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">
                        @if($comment->post)
                        <a href="{{ route('admin.posts.show', $comment->post_id) }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ $comment->post->title }}
                        </a>
                        @else
                        <span class="text-gray-500">Bài viết đã bị xóa</span>
                        @endif
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Tác giả:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">
                        @if($comment->creator)
                        <a href="{{ route('user.show', $comment->creator->slug) }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ $comment->creator->name }}
                        </a>
                        @else
                        <span class="text-gray-500">Ẩn danh</span>
                        @endif
                    </dd>
                </div>

                @if($comment->reply_to_username)
                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Trả lời cho:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">{{ $comment->reply_to_username }}</dd>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Ngày tạo:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">{{ $comment->created_at->format('d/m/Y H:i:s') }}</dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Cập nhật lúc:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">{{ $comment->updated_at->format('d/m/Y H:i:s') }}</dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 py-3 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-500">Lượt thích:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">
                        <span class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                            </svg>
                            {{ $comment->like_count }}
                        </span>
                    </dd>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 py-3">
                    <dt class="text-sm font-medium text-gray-500">Nội dung:</dt>
                    <dd class="mt-1 text-sm text-gray-900 md:mt-0 md:col-span-2">
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            {{ $comment->comment }}
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection