@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Quản lý nhiệm vụ</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Add button -->
            <a href="{{ route('admin.tasks.create') }}" class="p-2 flex items-center gap-1 rounded-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="ml-2">Thêm nhiệm vụ</span>
            </a>
        </div>
    </div>

    <!-- Alert if any -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <header class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Danh sách nhiệm vụ <span class="text-gray-400 font-medium">{{ $tasks->total() }}</span></h2>
        </header>
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 border-t border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">ID</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Tiêu đề</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Kế hoạch</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Trạng thái</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Người phụ trách</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Thời hạn</div>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Hành động</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200">
                    @foreach($tasks as $task)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-left">{{ $task->id }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800 truncate max-w-xs">{{ $task->title }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-left">
                                @if($task->plan)
                                <a href="{{ route('admin.plans.show', $task->plan) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $task->plan->title }}
                                </a>
                                @else
                                <span class="text-gray-500">Không có</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-left">
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
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-left">
                                @if($task->assignee)
                                <div class="flex items-center">
                                    <div class="w-6 h-6 shrink-0 mr-2">
                                        <img class="rounded-full" src="{{ $task->assignee->avatar_url ?? '/images/default-avatar.png' }}" width="24" height="24" alt="{{ $task->assignee->name }}">
                                    </div>
                                    <div class="text-sm">{{ $task->assignee->name }}</div>
                                </div>
                                @else
                                <span class="text-gray-500">Chưa phân công</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-left">
                                @if($task->due_date)
                                {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                @else
                                <span class="text-gray-500">Không có</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-right flex justify-end items-center space-x-2">
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
        <!-- Pagination -->
        <div class="px-5 py-3 border-t border-gray-200">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
@endsection