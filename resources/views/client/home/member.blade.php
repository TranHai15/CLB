@extends('layouts.home')
@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Thêm Thành Viên Câu Lạc Bộ</h1>
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
                <form method="POST" action="{{ route('club.members.store') }}" class="space-y-6">
                    @csrf

                    <!-- Họ và tên -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Nguyễn Văn A">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-600">*</span></label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="example@gmail.com">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mã học sinh -->
                    <div>
                        <label for="student_code" class="block text-sm font-medium text-gray-700">Mã học sinh <span class="text-red-600">*</span></label>
                        <input type="text" name="student_code" id="student_code" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="VD: 22IT123">
                        @error('student_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Khóa nhập học -->
                    <div>
                        <label for="enrollment_year" class="block text-sm font-medium text-gray-700">Khóa nhập học <span class="text-red-600">*</span></label>
                        <input type="text" name="enrollment_year" id="enrollment_year" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="VD: 2022">
                        @error('enrollment_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Chuyên ngành -->
                    <div>
                        <label for="major" class="block text-sm font-medium text-gray-700">Chuyên ngành <span class="text-red-600">*</span></label>
                        <select name="major" id="major" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">-- Chọn chuyên ngành --</option>
                            <option value="IT">Công nghệ thông tin</option>
                            <option value="CE">Kỹ thuật máy tính</option>
                            <option value="SE">Kỹ thuật phần mềm</option>
                            <option value="IS">Hệ thống thông tin</option>
                            <option value="AI">Trí tuệ nhân tạo</option>
                            <option value="other">Khác</option>
                        </select>
                        @error('major')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Số điện thoại -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại <span class="text-red-600">*</span></label>
                        <input type="tel" name="phone" id="phone" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="0123456789">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giới tính -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Giới tính <span class="text-red-600">*</span></label>
                        <div class="mt-2 flex space-x-6">
                            <div class="flex items-center">
                                <input id="gender_male" name="gender" type="radio" value="male" required
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="gender_male" class="ml-2 block text-sm text-gray-700">Nam</label>
                            </div>
                            <div class="flex items-center">
                                <input id="gender_female" name="gender" type="radio" value="female"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="gender_female" class="ml-2 block text-sm text-gray-700">Nữ</label>
                            </div>
                            <div class="flex items-center">
                                <input id="gender_other" name="gender" type="radio" value="other"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="gender_other" class="ml-2 block text-sm text-gray-700">Khác</label>
                            </div>
                        </div>
                        @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end pt-4 space-x-3">
                        <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Hủy
                        </button>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Thêm thành viên
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection