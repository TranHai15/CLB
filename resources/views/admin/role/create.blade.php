@extends('layouts.admin')

@section('title', 'Thêm quyền mới')

@section('content')


<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Thêm quyền mới</h3>
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

            <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Chọn người dùng</label>
                        <div class="mt-1">
                            <button type="button"
                                onclick="openUserModal()"
                                class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span id="selected_user_text">Chọn người dùng</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <input type="hidden" name="user_id" id="selected_user_id" value="{{ old('user_id') }}" required>
                        @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chọn vai trò</label>
                        <div class="grid grid-cols-2 gap-2" id="roles_container">
                            @foreach($roles as $role)
                            <label class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="roles[]" value="{{ $role->id }}"
                                    class="hidden peer"
                                    {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                <div class="w-full text-sm font-medium text-gray-900 peer-checked:text-blue-600">
                                    {{ $role->name }}
                                </div>
                                <div class="absolute right-3 hidden peer-checked:block">
                                    <i class="fas fa-check text-blue-600"></i>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('roles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="permissions_section" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chọn quyền</label>
                        <div class="grid grid-cols-2 gap-2" id="permissions_container">
                            @foreach($permissions as $permission)
                            <label class="relative flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="hidden peer"
                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                <div class="w-full text-sm font-medium text-gray-900 peer-checked:text-blue-600">
                                    {{ $permission->name }}
                                </div>
                                <div class="absolute right-3 hidden peer-checked:block">
                                    <i class="fas fa-check text-blue-600"></i>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('permissions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.roles.index') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Hủy
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal chọn người dùng -->
<div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Chọn người dùng</h3>
            <button type="button" onclick="closeUserModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mb-4">
            <input type="text" id="user_search"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Nhập email để tìm kiếm...">
        </div>
        <div id="search_results" class="max-h-60 overflow-y-auto">
            <!-- Kết quả tìm kiếm sẽ được thêm vào đây -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userModal = document.getElementById('userModal');
        const userSearch = document.getElementById('user_search');
        const searchResults = document.getElementById('search_results');
        const selectedUserId = document.getElementById('selected_user_id');
        const selectedUserText = document.getElementById('selected_user_text');
        const rolesContainer = document.getElementById('roles_container');
        const permissionsSection = document.getElementById('permissions_section');
        const permissionsContainer = document.getElementById('permissions_container');

        // Xử lý tìm kiếm người dùng
        let searchTimeout;
        userSearch.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/admin/roles/search?email=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';

                        if (data.user.length > 0) {
                            data.user.forEach(user => {
                                const div = document.createElement('div');
                                div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                                div.textContent = `${user.name} (${user.email})`;
                                div.onclick = () => selectUser(user);
                                searchResults.appendChild(div);
                            });
                        } else {
                            searchResults.innerHTML = '<div class="p-2 text-gray-500">Không tìm thấy kết quả</div>';
                        }
                    });
            }, 300);
        });

        // Xử lý chọn người dùng
        function selectUser(user) {
            selectedUserId.value = user.id;
            selectedUserText.textContent = `${user.name} (${user.email})`;
            closeUserModal();
        }

        // Xử lý hiển thị quyền theo vai trò
        rolesContainer.addEventListener('change', function(e) {
            if (e.target.type === 'radio') {
                const selectedRole = e.target.closest('label').querySelector('.text-gray-900').textContent.trim();

                const isAdmin = selectedRole.toLowerCase().includes('admin');
                const isHead = selectedRole.toLowerCase().includes('head');
                const isStaff = selectedRole.toLowerCase().includes('staff');

                if (isAdmin || isHead) {
                    permissionsSection.classList.add('hidden');
                    // Bỏ chọn tất cả quyền
                    permissionsContainer.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                } else if (isStaff) {
                    permissionsSection.classList.remove('hidden');
                    // Lọc quyền theo phòng ban của nhân viên
                    const department = selectedRole
                        .split('-')
                        .slice(-3)
                        .join('-');


                    permissionsContainer.querySelectorAll('label').forEach(label => {
                        const permissionName = label.querySelector('.text-gray-900').textContent.trim().toLowerCase();
                        if (permissionName.includes(department)) {
                            label.style.display = '';
                        } else {
                            label.style.display = 'none';
                            label.querySelector('input[type="checkbox"]').checked = false;
                        }
                    });
                }
            }
        });
    });

    // Hàm mở modal
    function openUserModal() {
        document.getElementById('userModal').classList.remove('hidden');
        document.getElementById('user_search').value = '';
        document.getElementById('search_results').innerHTML = '';
    }

    // Hàm đóng modal
    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
    }

    // Đóng modal khi click ra ngoài
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('userModal');
        if (e.target === modal) {
            closeUserModal();
        }
    });
</script>
@endpush