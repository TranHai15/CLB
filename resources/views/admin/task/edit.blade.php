@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Chỉnh sửa nhiệm vụ</h1>
            <p class="mt-1 text-sm text-gray-600">
                Thuộc kế hoạch: <span class="font-medium">{{ $task->plan->title }}</span>
            </p>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.plans.show', $task->plan_id) }}" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                <svg class="w-4 h-4 fill-current text-gray-400 shrink-0" viewBox="0 0 16 16">
                    <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                </svg>
                <span class="ml-2">Quay lại</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 p-6 mb-8">
        <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Basic Information Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin cơ bản</h3>

                    <!-- Plan -->
                    <div class="mb-4">
                        <label for="plan_id" class="block text-sm font-medium text-gray-700">Kế hoạch <span class="text-red-500">*</span></label>
                        <select name="plan_id" id="plan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Chọn kế hoạch --</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id', $task->plan_id) == $plan->id ? 'selected' : '' }}>
                                {{ $plan->title }} ({{ $plan->start_date }} - {{ $plan->end_date }})
                            </option>
                            @endforeach
                        </select>
                        @error('plan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Date and Due Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Ngày bắt đầu</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $task->start_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Thời hạn</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="todo" {{ old('status', $task->status) == 'todo' ? 'selected' : '' }}>Cần làm</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>Đang làm</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assignee -->
                    <div class="mb-4">
                        <label for="assignee_id" class="block text-sm font-medium text-gray-700">Người phụ trách</label>
                        <select name="assignee_id" id="assignee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Chọn người phụ trách --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assignee_id', $task->assignee_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('assignee_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin bổ sung</h3>

                    <!-- Issues -->
                    <div class="mb-4">
                        <label for="issue_text" class="block text-sm font-medium text-gray-700">Vấn đề gặp phải</label>
                        <textarea name="issue_text" id="issue_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('issue_text', $task->issue_text) }}</textarea>
                        @error('issue_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Solution -->
                    <div class="mb-4">
                        <label for="solution_text" class="block text-sm font-medium text-gray-700">Giải pháp</label>
                        <textarea name="solution_text" id="solution_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('solution_text', $task->solution_text) }}</textarea>
                        @error('solution_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Evidence URL -->
                    <div class="mb-4">
                        <label for="evidence_url" class="block text-sm font-medium text-gray-700">URL minh chứng</label>
                        <input type="url" name="evidence_url" id="evidence_url" value="{{ old('evidence_url', $task->evidence_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Liên kết đến bằng chứng hoàn thành nhiệm vụ (Google Drive, GitHub, v.v.)</p>
                        @error('evidence_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gray-50 p-4 rounded-md">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Thông tin hệ thống</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Tạo bởi:</span>
                            <span class="ml-2">{{ $task->creator ? $task->creator->name : 'Không có' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Ngày tạo:</span>
                            <span class="ml-2">{{ $task->created_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Cập nhật lần cuối:</span>
                            <span class="ml-2">{{ $task->updated_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Người cập nhật:</span>
                            <span class="ml-2">{{ $task->updater ? $task->updater->name : 'Không có' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Cập nhật nhiệm vụ</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection