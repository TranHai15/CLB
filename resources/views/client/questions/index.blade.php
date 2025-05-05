@extends('layouts.home')

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    <div class="container mx-auto max-w-7xl px-4 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Câu hỏi</h1>
                <a href="{{ route('create.post') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Đặt câu hỏi
                </a>
            </div>

            <div class="space-y-6">
                @foreach($questions as $question)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <img src="{{ $question['author']['avatar'] }}"
                                alt="{{ $question['author']['name'] }}"
                                class="w-12 h-12 rounded-full">
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold mb-2">
                                <a href="{{ route('questions.show', $question['id']) }}" class="hover:text-blue-600">
                                    {{ $question['title'] }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $question['content'] }}</p>

                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <a href="/category/{{ $question['category']['slug'] }}"
                                    class="bg-gray-100 px-3 py-1 rounded-full hover:bg-gray-200">
                                    {{ $question['category']['name'] }}
                                </a>
                                <span>{{ $question['answers_count'] }} câu trả lời</span>
                                <span>{{ number_format($question['views']) }} lượt xem</span>
                                <span>{{ \Carbon\Carbon::parse($question['created_at'])->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8 lg:col-span-1">
            <!-- Categories Filter -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Danh mục</h3>
                <select id="categorySelect" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                    <option value="{{ $category['slug'] }}">{{ $category['name'] }} ({{ $category['count'] }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Latest Posts -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4">Bài viết mới nhất</h3>
                <div class="space-y-4">
                    @foreach($latestPosts as $post)
                    <div class="flex gap-4">
                        <img src="{{ $post['thumbnail'] }}"
                            alt="{{ $post['title'] }}"
                            class="w-20 h-20 object-cover rounded-lg">
                        <div>
                            <h4 class="font-medium text-sm mb-1 line-clamp-2">
                                <a href="{{ route('posts.show', $post['id']) }}" class="hover:text-blue-600">
                                    {{ $post['title'] }}
                                </a>
                            </h4>
                            <div class="text-xs text-gray-500">
                                <span>{{ $post['author'] }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ \Carbon\Carbon::parse($post['created_at'])->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
@endsection