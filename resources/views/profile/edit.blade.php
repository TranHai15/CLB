@extends('layouts.home')
<style>
    .post-title {
        color: white !important;
    }

    .post-input {
        background: #1f2937 !important;
    }

    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        /* 12px */
        border: 1px solid transparent;
    }
</style>
@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3 ">
            <div class="post-card rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Thông tin cá nhân</h2>
                    <button id="editToggleBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="hidden sm:inline">Chỉnh sửa</span>
                    </button>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    <div class="space-y-6">
                        <!-- Avatar Section -->
                        <div class="flex items-center gap-6">
                            <div class="relative">
                                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-gray-100">
                                <label for="avatar" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 transition hidden edit-only">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">{{ auth()->user()->name }}</h3>
                                <p class="text-gray-500 edit-only hidden">Thay đổi ảnh đại diện</p>
                            </div>
                        </div>

                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium post-title mb-2">Tên hiển thị</label>
                            <input type="text"
                                name="name"
                                id="name"
                                value="{{ auth()->user()->name }}"
                                class="w-full px-4 py-2 border post-input border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 edit-only hidden"
                                disabled>
                            <div class="view-only py-2">{{ auth()->user()->name }}</div>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio Input -->
                        <div>
                            <label for="bio" class="block text-sm font-medium post-title mb-2">Giới thiệu</label>
                            <textarea name="bio"
                                id="bio"
                                rows="4"
                                class="w-full px-4 py-2 border post-input border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 edit-only hidden"
                                disabled>{{ auth()->user()->bio }}</textarea>
                            <div class="view-only py-2">{{ auth()->user()->bio ?: 'Chưa có thông tin giới thiệu' }}</div>
                            @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between edit-only hidden">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Cập nhật</span>
                            </button>
                            <button type="button" id="cancelEditBtn" class="text-gray-600 bg-indigo-200 p-2 rounded-sm hover:text-gray-800 hover:bg-white transition">
                                Hủy
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-1">
            <div class="post-card rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4">Menu</h3>
                <nav class="space-y-2">
                    <a href="{{ route('user.show', auth()->user()->slug) }}" class="flex items-center gap-3 px-4 py-2 post-title hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Danh sách câu hỏi</span>
                    </a>
                    <a href="{{ route('questions.create') }}" class="flex items-center gap-3 px-4 py-2 post-title hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Đặt câu hỏi mới</span>
                    </a>
                    <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-4 py-2 post-title hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span>Thông báo</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Thông tin cá nhân</span>
                    </a>
                </nav>

                <!-- Account Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Tài khoản</h4>
                    <div class="space-y-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-black bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Đăng xuất</span>
                            </button>
                        </form>

                        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Xóa tài khoản</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editToggleBtn = document.getElementById('editToggleBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.querySelector('img[alt="{{ auth()->user()->name }}"]');
        const editOnlyElements = document.querySelectorAll('.edit-only');
        const viewOnlyElements = document.querySelectorAll('.view-only');
        const nameInput = document.getElementById('name');
        const bioInput = document.getElementById('bio');

        // Hàm chuyển đổi giữa chế độ xem và chỉnh sửa
        function toggleEditMode(isEditing) {
            editOnlyElements.forEach(el => {
                el.classList.toggle('hidden', !isEditing);
            });
            viewOnlyElements.forEach(el => {
                el.classList.toggle('hidden', isEditing);
            });

            // Cập nhật trạng thái disabled của các input
            nameInput.disabled = !isEditing;
            bioInput.disabled = !isEditing;

            // Cập nhật nút chỉnh sửa
            if (isEditing) {
                editToggleBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Hủy</span>
                `;
                editToggleBtn.classList.remove('bg-blue-600');
                editToggleBtn.classList.add('bg-gray-600');
            } else {
                editToggleBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Chỉnh sửa</span>
                `;
                editToggleBtn.classList.remove('bg-gray-600');
                editToggleBtn.classList.add('bg-blue-600');
            }
        }

        // Xử lý sự kiện click nút chỉnh sửa
        editToggleBtn.addEventListener('click', function() {
            const isCurrentlyEditing = !editOnlyElements[0].classList.contains('hidden');
            toggleEditMode(!isCurrentlyEditing);
        });

        // Xử lý sự kiện click nút hủy
        cancelEditBtn.addEventListener('click', function() {
            toggleEditMode(false);
            // Reset form về giá trị ban đầu
            nameInput.value = "{{ auth()->user()->name }}";
            bioInput.value = "{{ auth()->user()->bio }}";
            avatarPreview.src = "{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}";
        });

        // Xử lý upload avatar
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
@endsection