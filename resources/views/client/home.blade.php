@extends('layouts.home')

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Main List -->
    <main class="lg:col-span-3 space-y-8">
        <h2 class="text-2xl font-semibold">Bài viết mới nhất</h2>
        @foreach($posts as $post)
        <article class="flex bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
            <a href="{{ $post['link'] }}" class="w-1/3">
                <img src="{{ $post['thumbnail'] }}" alt="{{ $post['title'] }}" class="h-full w-full object-cover">
            </a>
            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-1 truncate">
                        <a href="{{ $post['link'] }}">{{ $post['title'] }}</a>
                    </h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $post['createdAt'] }}</p>
                    <p class="text-gray-700 line-clamp-3">{{ $post['excerpt'] }}</p>
                </div>
                <div class="mt-4 flex flex-wrap items-center text-sm text-gray-500 gap-2">
                    <!-- Danh mục -->
                    @foreach($post['categories'] as $category)
                    <a href="#" class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                        {{ $category['name'] }}
                    </a>
                    @endforeach
                </div>
                <div class="mt-2 flex flex-wrap items-center text-sm text-gray-500 gap-2">
                    <!-- Thẻ -->
                    @foreach($post['tags'] as $tag)
                    <a href="#" class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium hover:bg-green-200 transition">
                        #{{ $tag['name'] }}
                    </a>
                    @endforeach
                </div>
                <div class="mt-4 flex items-center space-x-3">
                    <strong>Tác giả</strong>
                    <!-- <a href="#">
                        <img src="{{ $post['author']['avatar'] }}" alt="{{ $post['author']['name'] }}" class="h-8 w-8 rounded-full object-cover">
                    </a> -->
                    <a href="#" class="text-sm font-medium text-gray-700 hover:underline">
                        {{ $post['author']['name'] }}
                    </a>
                </div>
            </div>
        </article>
        @endforeach

    </main>
    <!-- Sidebar -->
    <aside class="space-y-8 lg:col-span-1">
        <!-- Widget lọc giả lập -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">Danh mục</h3>
            <select id="categorySelect" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                <option value="{{ $category['slug'] }}">{{ $category['name'] }} ({{ $category['count'] }})</option>
                @endforeach
            </select>
        </div>
        <!-- Top Posts -->
        <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Câu hỏi mới nhất</h2>
            <ul class="space-y-3">
                @foreach($topPosts as $post)
                <li class="flex items-center space-x-3">
                    <img src="{{ $post['thumbnail'] }}" alt=""
                        class="h-10 w-10 rounded object-cover">
                    <a href="{{ route('questions.show', $post['id']) }}"
                        class="font-medium text-gray-800 truncate">{{ $post['title'] }}</a>
                </li>
                @endforeach
            </ul>
        </div>


    </aside>

</div>
@endsection