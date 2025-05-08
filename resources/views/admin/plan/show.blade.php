@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Chi tiết kế hoạch</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.plans.index') }}" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                <svg class="w-4 h-4 fill-current text-gray-400 shrink-0" viewBox="0 0 16 16">
                    <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                </svg>
                <span class="ml-2">Quay lại</span>
            </a>
            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
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

    <!-- Plan Details -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <div class="p-6">
            <!-- Title and Status -->
            <div class="mb-6">
                <div class="flex flex-wrap items-center justify-between mb-2">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $plan->title }}</h2>
                    <div class="mt-2 sm:mt-0">
                        @if($plan->status === 'pending')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800">
                            Chờ thực hiện
                        </span>
                        @elseif($plan->status === 'ongoing')
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                            Đang thực hiện
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                            Hoàn thành
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($plan->description)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Mô tả</h3>
                <div class="prose max-w-none bg-gray-50 p-4 rounded-md border border-gray-200">
                    {!! nl2br(e($plan->description)) !!}
                </div>
            </div>
            @endif

            <!-- Date Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Thời gian</h3>
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ngày bắt đầu</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($plan->start_date)->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ngày kết thúc</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($plan->end_date)->format('d/m/Y') }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($plan->plan_note)
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Ghi chú</h3>
                <div class="prose max-w-none bg-gray-50 p-4 rounded-md border border-gray-200">
                    {!! nl2br(e($plan->plan_note)) !!}
                </div>
            </div>
            @endif

            <!-- Tasks -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Danh sách nhiệm vụ ({{ $plan->tasks->count() }})</h3>
                    <a href="{{ route('admin.plans.tasks.create', $plan) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0 mr-1" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        Thêm nhiệm vụ
                    </a>
                </div>

                <!-- Task Status Summary -->
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div class="bg-white p-3 rounded-md border border-gray-200 shadow-sm">
                            <span class="text-gray-500 text-sm">Cần làm</span>
                            <p class="text-2xl font-bold text-gray-700 mt-1">
                                {{ $plan->tasks->where('status', 'todo')->count() }}
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md border border-gray-200 shadow-sm">
                            <span class="text-blue-500 text-sm">Đang làm</span>
                            <p class="text-2xl font-bold text-blue-700 mt-1">
                                {{ $plan->tasks->where('status', 'in_progress')->count() }}
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md border border-gray-200 shadow-sm">
                            <span class="text-green-500 text-sm">Hoàn thành</span>
                            <p class="text-2xl font-bold text-green-700 mt-1">
                                {{ $plan->tasks->where('status', 'completed')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($plan->tasks->isEmpty())
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200 text-center text-gray-500">
                    Chưa có nhiệm vụ nào. <a href="{{ route('admin.plans.tasks.create', $plan) }}" class="text-indigo-600 hover:text-indigo-900">Thêm nhiệm vụ mới</a>.
                </div>
                @else
                <div class="bg-gray-50 rounded-md border border-gray-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người phụ trách</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời hạn</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($plan->tasks->sortBy('stt') as $task)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $task->stt }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                    @if($task->description)
                                    <div class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($task->description, 60) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($task->status === 'todo')
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                        Cần làm
                                    </span>
                                    @elseif($task->status === 'in_progress')
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                        Đang làm
                                    </span>
                                    @else
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                        Hoàn thành
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($task->assignee)
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 flex-shrink-0 mr-2">
                                            <img class="h-6 w-6 rounded-full" src="{{ $task->assignee->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $task->assignee->name }}">
                                        </div>
                                        <div class="text-sm text-gray-900">{{ $task->assignee->name }}</div>
                                    </div>
                                    @else
                                    <span class="text-sm text-gray-500">Chưa phân công</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Không có' }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-3">
                                        <!-- Quick Status Update Buttons -->
                                        <div class="flex space-x-1">
                                            <form action="{{ route('admin.tasks.update-status', $task) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="todo">
                                                <button type="submit" class="w-6 h-6 rounded-full {{ $task->status === 'todo' ? 'bg-gray-200 ring-2 ring-gray-400' : 'bg-gray-100 hover:bg-gray-200' }}" title="Cần làm"></button>
                                            </form>
                                            <form action="{{ route('admin.tasks.update-status', $task) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="w-6 h-6 rounded-full {{ $task->status === 'in_progress' ? 'bg-blue-300 ring-2 ring-blue-500' : 'bg-blue-100 hover:bg-blue-200' }}" title="Đang làm"></button>
                                            </form>
                                            <form action="{{ route('admin.tasks.update-status', $task) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="w-6 h-6 rounded-full {{ $task->status === 'completed' ? 'bg-green-300 ring-2 ring-green-500' : 'bg-green-100 hover:bg-green-200' }}" title="Hoàn thành"></button>
                                            </form>
                                        </div>

                                        <a href="{{ route('admin.tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900" title="Xem chi tiết">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900" title="Chỉnh sửa">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhiệm vụ này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

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
                                    @if($plan->creator)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full mr-2 overflow-hidden">
                                            <img src="{{ $plan->creator->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $plan->creator->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span>{{ $plan->creator->name }}</span>
                                    </div>
                                    @else
                                    Không có
                                    @endif
                                </dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Cập nhật bởi</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    @if($plan->updater)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full mr-2 overflow-hidden">
                                            <img src="{{ $plan->updater->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $plan->updater->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span>{{ $plan->updater->name }}</span>
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
                                <dd class="text-sm text-gray-900 col-span-2">{{ $plan->id }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $plan->created_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Cập nhật lần cuối</dt>
                                <dd class="text-sm text-gray-900 col-span-2">{{ $plan->updated_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 border-t pt-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.plans.edit', $plan) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        Chỉnh sửa kế hoạch
                    </a>
                </div>
                <div>
                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa kế hoạch này? Tất cả các nhiệm vụ liên quan cũng sẽ bị xóa.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn border-red-200 hover:border-red-300 text-red-600">
                            <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                            </svg>
                            <span>Xóa kế hoạch</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection