@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl px-4 py-8">
    <article class="bg-white rounded-lg shadow p-6">
        <!-- Tiêu đề -->

        <h1 class="text-3xl font-bold mb-4">{{ $post["title"] }}</h1>

        <!-- Thông tin tác giả và ngày đăng -->
        <div class="flex items-center mb-4">
            <a href="#">
                <img src="{{ $post["author"]['avatar'] }}" alt="{{ $post["author"]['name'] }}" class="h-10 w-10 rounded-full object-cover mr-3">
            </a>
            <div>
                <a href="#" class="text-sm font-medium text-gray-700 hover:underline">
                    {{ $post['author']['name'] }}
                </a>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($post["createdAt"])->format('d/m/Y') }} • {{ $post["views"] }} lượt xem</p>
            </div>
        </div>

        <!-- Nội dung bài viết -->
        <div class="prose max-w-none">

        </div>

        <!-- Danh mục -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Danh mục:</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($post["categories"] as $category)
                <a href="#" class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                    {{ $category['name'] }}
                </a>
                @endforeach
            </div>
        </div>
        <!-- Thẻ -->


    </article>
</div>
@endsection