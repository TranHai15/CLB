@extends('layouts.home')
@auth
<style>
    @keyframes typing {
        0% {
            width: 0
        }

        50% {
            width: 100%
        }

        70% {
            width: 100%
        }

        100% {
            width: 0
        }
    }

    @keyframes blink {
        50% {
            border-color: transparent
        }
    }

    .animate-typing {
        display: inline-block;
        width: 0;
    }
</style>
@endauth
@section('content')
<div class="bg-white shadow-sm overflow-hidden">
    <div class="relative h-[calc(100vh-70px)]">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1499750310107-5fef28a66643" alt="Hero background">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-800 to-blue-600 mix-blend-multiply opacity-90"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="font-mono text-5xl font-black tracking-tight text-white sm:text-6xl lg:text-7xl leading-tight">
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">Chia sẻ kiến thức,</span>
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">kết nối cộng đồng</span>
            </h1>
            <p class="mt-8 text-xl font-light text-blue-100 max-w-3xl leading-relaxed font-['Fira Code']">
                <span class="animate-typing border-r-4 border-blue-100 whitespace-nowrap overflow-hidden"
                    style="animation: typing 4s steps(50) infinite, blink 0.8s step-end infinite alternate;">
                    Nơi chia sẻ kiến thức, kinh nghiệm và kết nối với cộng đồng lập trình viên Việt Nam.
                </span>
            </p>

            <div class="mt-12">
                <a href="{{ route('questions.create') }}"
                    class="inline-flex items-center px-8 py-4 text-lg font-semibold rounded-lg
                          bg-gradient-to-r from-blue-500 to-blue-700 text-white
                          transform transition duration-200 ease-in-out
                          hover:scale-105 hover:shadow-lg hover:from-blue-600 hover:to-blue-800
                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span class="mr-2">Đặt câu hỏi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="container mx-auto max-w-7xl px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <main class="lg:col-span-3 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-gray-900">Bài viết mới nhất</h2>
                <a href="{{ route('blog') }}" class="text-blue-600 hover:text-blue-800 font-medium">Xem tất cả →</a>
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

                            <p class="text-gray-600 mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}</p>

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
                        <span class="text-gray-700">{{ $category->name }}</span>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $category->posts_count }}
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
                    <a href="{{ route('posts.show', $post->id) }}"
                        class="block py-4 hover:bg-gray-50 transition-colors first:pt-0 last:pb-0">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $post->image ?? '' }}"
                                alt=""
                                class="h-12 w-12 rounded-lg object-cover">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 line-clamp-2">
                                    {{ $post->title }}
                                </h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $post->created_at->diffForHumans() }}
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