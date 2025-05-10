@extends('layouts.home')

@section('content')

<div class="container mx-auto max-w-7xl px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <main class="lg:col-span-3 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-gray-900">Bài viết mới nhất</h2>

            </div>

            <div class="grid gap-8">
                @foreach($posts as $post)
                <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <a href="{{ route('posts.show', $post->slug) }}" class="md:w-1/3 h-64 md:h-auto overflow-hidden">
                            <img src="{{ $post->image ?? '' }}"
                                alt="{{ $post->title }}"
                                class="h-full w-full object-cover transform hover:scale-105 transition duration-500">
                        </a>
                        <div class="flex-1 p-6">
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($post->category)
                                <a href="{{ route('category.show', $post->category->slug) }}" class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-100 transition">
                                    {{ $post->category->name }}
                                </a>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold mb-2 hover:text-blue-600 transition-colors">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>



                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->slug) }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors">
                                    #{{ $tag->name }}
                                </a>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('user.show', $post->creator->slug ) }}">
                                        <img src="{{ $post->creator->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($post->creator->name) }}"
                                            alt="{{ $post->creator->name }}"
                                            class="h-10 w-10 rounded-full object-cover">
                                    </a>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $post->creator->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Đọc thêm →
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8">
            <!-- Categories -->
            <div class="bg-white rounded-xl shadow-sm p-6" x-data="{ isOpen: false }">
                <div class="flex items-center justify-between cursor-pointer" @click="isOpen = !isOpen">
                    <h3 class="text-xl font-bold text-gray-900">Danh mục</h3>
                    <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="space-y-2 mt-4" x-show="isOpen" x-transition>
                    @foreach($categories as $category)
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="text-gray-700">{{ $category['name'] }}</span>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $category['count'] }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Recent Questions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-900">Câu hỏi mới nhất</h3>
                <div class="divide-y divide-gray-100">
                    @foreach($topPosts as $post)
                    <a href="{{ route('questions.show', $post->slug) }}"
                        class="block py-4 hover:bg-gray-50 transition-colors first:pt-0 last:pb-0">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $post->image }}"
                                alt=""
                                class="h-12 w-12 rounded-lg object-cover">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 line-clamp-2">
                                    {{ $post->title }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection