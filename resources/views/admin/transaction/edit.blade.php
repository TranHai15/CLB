@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Chỉnh sửa giao dịch</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.transactions.index') }}" class="  p-[5px]  rounded-sm btn border-gray-200 hover:border-gray-300 text-gray-600">
                <svg class="w-4 h-4 fill-current text-gray-400 shrink-0" viewBox="0 0 16 16">
                    <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                </svg>
                <span class="ml-2">Quay lại</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 p-6 mb-8">
        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Basic Information Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin giao dịch</h3>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả <span class="text-red-500">*</span></label>
                        <input type="text" name="description" id="description" value="{{ old('description', $transaction->description) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Số tiền <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="number" name="amount" id="amount" value="{{ old('amount', $transaction->amount) }}" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                VNĐ
                            </span>
                        </div>
                        @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Loại giao dịch <span class="text-red-500">*</span></label>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center">
                                <input id="income" name="type" type="radio" value="in" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" {{ old('type', $transaction->type) == 'income' ? 'checked' : '' }} required>
                                <label for="income" class="ml-3 block text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Thu
                                    </span>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="expense" name="type" type="radio" value="out" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" {{ old('type', $transaction->type) == 'expense' ? 'checked' : '' }}>
                                <label for="expense" class="ml-3 block text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                        Chi
                                    </span>
                                </label>
                            </div>
                        </div>
                        @error('type')
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
                            <span class="ml-2">{{ $transaction->creator ? $transaction->creator->name : 'Không có' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Ngày tạo:</span>
                            <span class="ml-2">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Cập nhật lần cuối:</span>
                            <span class="ml-2">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Người cập nhật:</span>
                            <span class="ml-2">{{ $transaction->updater ? $transaction->updater->name : 'Không có' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="  p-[5px]  rounded-sm flex items-center btn bg-indigo-500 hover:bg-indigo-600 text-white">Cập nhật giao dịch</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection