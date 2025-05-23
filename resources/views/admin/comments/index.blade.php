@extends('layouts.admin')

<!-- @section('title', 'Quản lý bình luận') -->

@section('content')

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Quản lý bình luận</h1>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <header class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Danh sách bình luận <span class="text-gray-400 font-medium">{{ $comments->total() }}</span></h2>
        </header>
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 border-t border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Người dùng</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Bài viết</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nội dung</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Thời gian</div>
                        </th>
                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('head-phong-truyen-thong') || auth()->user()->hasRole('staff-phong-truyen-thong'))
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Hành động</div>
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200">
                    @forelse($comments as $comment)

                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
                                    <img class="rounded-full" src="{{ $comment->creator->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->creator->name) }}" width="40" height="40" alt="{{ $comment->creator->name ?? "Lỗi"}}">
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $comment->creator->name }}</div>
                                    <div class="text-gray-500">{{ $comment->creator->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-left">{{ $comment->post->title }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-left">{{ Illuminate\Support\Str::limit($comment->comment, 100) }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-left">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-right flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.comments.show', $comment) }}" class="admin-action-btn admin-view-btn" title="Xem chi tiết">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('head-phong-truyen-thong') || auth()->user()->hasRole('staff-phong-truyen-thong'))
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-action-btn admin-delete-btn" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                            Không có bình luận nào
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-5 py-3 border-t border-gray-200">
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection