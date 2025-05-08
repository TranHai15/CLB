@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Chi tiết nhiệm vụ</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.plans.show', $task->plan_id) }}" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                <svg class="w-4 h-4 fill-current text-gray-400 shrink-0" viewBox="0 0 16 16">
                    <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                </svg>
                <span class="ml-2">Quay lại kế hoạch</span>
            </a>
            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                </svg>
                <span class="ml-2">Chỉnh sửa</span>
            </a>
        </div>
    </div>

    <!-- Alert if any -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Task Details -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <div class="p-6">
            <!-- Title and Status -->
            <div class="mb-6">
                <div class="flex flex-wrap items-center justify-between mb-2">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $task->title }}</h2>
                    <div class="mt-2 sm:mt-0">
                        @if($task->status === 'todo')
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800">
                            Cần làm
                        </span>
                        @elseif($task->status === 'in_progress')
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                            Đang làm
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                            Hoàn thành
                        </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center text-gray-500 text-sm mt-1">
                    <span class="font-medium text-gray-700 mr-1">Thuộc kế hoạch:</span>
                    <a href="{{ route('admin.plans.show', $task->plan) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                        <span>{{ $task->plan->title }}</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Status Update -->
            <div class="mb-6 bg-gray-50 p-4 rounded-md border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Cập nhật trạng thái</h3>
                <div class="flex flex-wrap gap-2">
                    <form action="{{ route('admin.tasks.update-status', $task) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="todo">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium {{ $task->status === 'todo' ? 'text-gray-800 bg-gray-200' : 'text-gray-700 bg-white hover:bg-gray-50' }}">
                            Cần làm
                        </button>
                    </form>
                    <form action="{{ route('admin.tasks.update-status', $task) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium {{ $task->status === 'in_progress' ? 'text-blue-800 bg-blue-200' : 'text-blue-700 bg-white hover:bg-blue-50' }}">
                            Đang làm
                        </button>
                    </form>
                    <form action="{{ route('admin.tasks.update-status', $task) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium {{ $task->status === 'completed' ? 'text-green-800 bg-green-200' : 'text-green-700 bg-white hover:bg-green-50' }}">
                            Hoàn thành
                        </button>
                    </form>
                </div>
            </div>

            <!-- Description -->
            @if($task->description)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Mô tả</h3>
                <div class="prose max-w-none bg-gray-50 p-4 rounded-md border border-gray-200">
                    {!! nl2br(e($task->description)) !!}
                </div>
            </div>
            @endif

            <!-- Basic Info -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Thông tin chung</h3>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ngày bắt đầu</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') : 'Không có' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Thời hạn</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Không có' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Người phụ trách</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($task->assignee)
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full mr-2 overflow-hidden">
                                        <img src="{{ $task->assignee->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $task->assignee->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span>{{ $task->assignee->name }}</span>
                                </div>
                                @else
                                Chưa phân công
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Thứ tự</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $task->stt }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Issue and Solution -->
            @if($task->issue_text || $task->solution_text)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Vấn đề và giải pháp</h3>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    @if($task->issue_text)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700">Vấn đề gặp phải</h4>
                        <div class="mt-2 prose prose-sm max-w-none">
                            {!! nl2br(e($task->issue_text)) !!}
                        </div>
                    </div>
                    @endif

                    @if($task->solution_text)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700">Giải pháp</h4>
                        <div class="mt-2 prose prose-sm max-w-none">
                            {!! nl2br(e($task->solution_text)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Evidence -->
            @if($task->evidence_url)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Minh chứng</h3>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <a href="{{ $task->evidence_url }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Xem minh chứng
                    </a>
                </div>
            </div>
            @endif

            <!-- Meta Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Thông tin hệ thống</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Author Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-3">Người tạo</h4>
                        <dl class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Tạo bởi</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    @if($task->creator)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full mr-2 overflow-hidden">
                                            <img src="{{ $task->creator->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $task->creator->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span>{{ $task->creator->name }}</span>
                                    </div>
                                    @else
                                    Không có
                                    @endif
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Cập nhật bởi</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    @if($task->updater)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full mr-2 overflow-hidden">
                                            <img src="{{ $task->updater->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $task->updater->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span>{{ $task->updater->name }}</span>
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
                        <h4 class="font-semibold text-gray-900 mb-3">Dữ liệu hệ thống</h4>
                        <dl class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">ID</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $task->id }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $task->created_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Cập nhật lần cuối</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $task->updated_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 border-t pt-6 flex items-center justify-between">
                <div class="flex space-x-3">
                    <a href="{{ route('admin.plans.show', $task->plan_id) }}" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                        <svg class="w-4 h-4 fill-current text-gray-400 shrink-0 mr-2" viewBox="0 0 16 16">
                            <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                        </svg>
                        Trở về kế hoạch
                    </a>
                    <a href="{{ route('admin.tasks.edit', $task) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        Chỉnh sửa nhiệm vụ
                    </a>
                </div>
                <div>
                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhiệm vụ này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn border-red-200 hover:border-red-300 text-red-600">
                            <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                            </svg>
                            <span>Xóa nhiệm vụ</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection