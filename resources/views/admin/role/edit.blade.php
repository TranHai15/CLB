@extends('layouts.admin')

@section('title', 'Sửa quyền')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Sửa quyền cho {{ $user->name }}</h3>
                    <a href="{{ route('admin.roles.index') }}" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            {{-- Thông báo lỗi validate --}}
            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Đã xảy ra lỗi:</strong>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Thông báo lỗi khác từ controller --}}
            @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
            @endif

            {{-- Thông báo thành công --}}
            @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('admin.roles.update', $user->slug) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                {{-- Hiển thị vai trò hiện tại --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Vai trò hiện tại</label>
                    <div class="mt-2">
                        @foreach($user->roles as $r)
                        <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded mr-2">{{ $r->name }}</span>
                        @endforeach
                    </div>
                </div>
                {{-- Hiển thị Quyền --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Quyền hiện tại</label>
                    <div class="mt-2">
                        @foreach($user->permissions as $r)
                        <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded mr-2">{{ $r->name }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Chọn vai trò mới (radio) --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Chọn vai trò Mới</label>
                    <div class="mt-2 space-y-2">
                        @foreach($roles as $role)
                        @if(!$user->hasRole($role))
                        <label class="inline-flex items-center">
                            <input type="radio" name="roles[]" value="{{ $role->id }}" data-rolename="{{ $role->name }}" class="form-radio" required>
                            <span class="ml-2">{{ $role->name }}</span>
                        </label>
                        @endif
                        @endforeach
                        @error('roles')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Quyền (checkboxes), chỉ hiển thị khi chọn staff và lọc theo phòng --}}
                <div id="permissions-container" class="mb-6 hidden">
                    <label class="block text-sm font-medium text-gray-700">Quyền</label>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        @foreach($permissions as $permission)
                        @php
                        // lấy slug phòng từ tên permission (sau dấu '-')
                        $parts = explode('-', $permission->name);
                        $deptSlug = array_pop($parts);
                        @endphp
                        <label class="inline-flex items-center permission-item" data-department="{{ $deptSlug }}">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-checkbox">
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('permissions')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">Hủy</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('input[name="roles[]"]');
        const permContainer = document.getElementById('permissions-container');
        const permItems = document.querySelectorAll('.permission-item');

        function togglePermissions() {
            const selected = Array.from(radios).find(r => r.checked);

            if (selected && selected.dataset.rolename.startsWith('staff-')) {
                // lấy slug phòng từ role name
                const slug = selected.dataset.rolename.split('-')[3]
                permItems.forEach(item => {

                    if (item.dataset.department === slug) {
                        console.log(item.dataset.department)
                        item.classList.remove('hidden');
                        item.querySelector('input').checked = false;
                    } else {
                        item.classList.add('hidden');
                        // bỏ tick với quyền không thuộc phòng
                        item.querySelector('input').checked = false;
                    }
                });
                permContainer.classList.remove('hidden');
            } else {
                permContainer.classList.add('hidden');
            }
        }

        radios.forEach(radio => radio.addEventListener('change', togglePermissions));
        // nếu nạp lại form có chọn trước
        togglePermissions();
    });
</script>
@endpush
@endsection