@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Chi tiết người dùng</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('admin.account.index') }}" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                <svg class="w-4 h-4 fill-current text-gray-400 shrink-0" viewBox="0 0 16 16">
                    <path d="M9.4 13.4l1.4-1.4-4-4 4-4-1.4-1.4L4 8z"></path>
                </svg>
                <span class="ml-2">Quay lại</span>
            </a>
            <a href="{{ route('admin.account.edit', $user) }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                </svg>
                <span class="ml-2">Chỉnh sửa</span>
            </a>
        </div>
    </div>

    <!-- User Details -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <div class="p-6">
            <!-- Avatar and Basic Info -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-6">
                <div class="w-24 h-24 relative">
                    <img src="{{ $user->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                    <div class="absolute bottom-0 right-0 w-5 h-5 rounded-full {{ $user->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500">ID: {{ $user->id }}</p>
                    <p class="text-gray-500">Slug: {{ $user->slug }}</p>
                </div>
            </div>

            <!-- Information Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Account Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-3">Thông tin tài khoản</h3>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->email }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Số điện thoại</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->phone ?? 'Chưa cập nhật' }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Giới tính</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                @if($user->gender === 'male')
                                Nam
                                @elseif($user->gender === 'female')
                                Nữ
                                @elseif($user->gender === 'other')
                                Khác
                                @else
                                Chưa cập nhật
                                @endif
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Loại tài khoản</dt>
                            <dd class="text-sm text-gray-900 col-span-2">Người dùng</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Trạng thái</dt>
                            <dd class="text-sm col-span-2">
                                @if($user->status === 'active')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    Hoạt động
                                </span>
                                @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    Không hoạt động
                                </span>
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
                            <dt class="text-sm font-medium text-gray-500">Ngày tạo</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->created_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Cập nhật lần cuối</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $user->updated_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 border-t pt-6 flex items-center justify-between">
                <div>
                    <form action="{{ route('admin.account.toggle-status', $user) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn border-gray-200 hover:border-gray-300 text-gray-600">
                            @if($user->status === 'active')
                            <span>Vô hiệu hóa tài khoản</span>
                            @else
                            <span>Kích hoạt tài khoản</span>
                            @endif
                        </button>
                    </form>
                </div>
                <div>
                    <form action="{{ route('admin.account.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn border-red-200 hover:border-red-300 text-red-600">
                            <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                            </svg>
                            <span>Xóa tài khoản</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection