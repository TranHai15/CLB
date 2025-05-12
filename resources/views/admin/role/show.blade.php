@extends('layouts.admin')

@section('title', 'Chi tiết phân quyền của tài khoản')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-user-shield mr-2 text-blue-600"></i>
                Chi tiết phân quyền
            </h3>
            <div class="space-x-2">
                <a href="{{ route('admin.roles.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <a href="{{ route('admin.roles.edit', $user->slug) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Sửa phân quyền
                </a>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Thông tin user --}}
            <div class="p-4 border rounded-lg bg-gray-50">
                <h4 class="text-lg font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-indigo-500"></i>Thông tin người dùng
                </h4>
                <p class="text-gray-700"><strong><i class="fas fa-id-badge mr-1"></i>Tên:</strong> {{ $user->name }}</p>
                <p class="text-gray-700"><strong><i class="fas fa-envelope mr-1"></i>Email:</strong> {{ $user->email }}</p>
            </div>

            {{-- Roles --}}
            <div class="p-4 border rounded-lg bg-gray-50">
                <h4 class="text-lg font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fas fa-user-tag mr-2 text-green-500"></i>Vai trò (Roles)
                </h4>
                @if($user->roles->isEmpty())
                <p class="text-gray-500"><i class="fas fa-exclamation-circle mr-1"></i>Chưa có role</p>
                @else
                <ul class="list-disc pl-6 space-y-1">
                    @foreach($user->roles as $role)
                    <li class="flex items-center"><i class="fas fa-check-circle text-green-600 mr-2"></i>{{ $role->name }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            {{-- Permissions --}}
            <div class="p-4 border rounded-lg bg-gray-50">
                <h4 class="text-lg font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fas fa-key mr-2 text-yellow-500"></i>Quyền (Permissions)
                </h4>
                @if($user->permissions->isEmpty())
                <p class="text-gray-500"><i class="fas fa-exclamation-circle mr-1"></i>Chưa có permission trực tiếp</p>
                @else
                <ul class="list-disc pl-6 space-y-1">
                    @foreach($user->permissions as $perm)
                    <li class="flex items-center"><i class="fas fa-check text-yellow-600 mr-2"></i>{{ $perm->name }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection