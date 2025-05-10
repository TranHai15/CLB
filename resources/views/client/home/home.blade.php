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
        overflow: hidden;
        white-space: nowrap;
        border-right: 3px solid;
        animation: typing 3.5s steps(40, end) infinite,
            blink .75s step-end infinite;
    }

    .post-card {
        transition: all 0.3s ease;
    }

    .post-card:hover {
        transform: translateY(-5px);
    }

    .category-badge {
        transition: all 0.2s ease;
    }

    .category-badge:hover {
        transform: scale(1.05);
    }

    .hero-title {
        font-family: var(--font-secondary);
        letter-spacing: -0.02em;
    }

    .hero-section {
        height: 100vh;
        min-height: 600px;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        position: relative;
        z-index: 10;
    }

    .hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        transition: opacity 1s ease;
    }

    .hero-bg.active {
        opacity: 1;
    }

    .hero-bg:not(.active) {
        opacity: 0;
    }

    .hero-pagination {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 1rem;
        z-index: 20;
    }

    .hero-pagination-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .hero-pagination-dot.active {
        background: white;
        transform: scale(1.2);
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0px);
        }
    }
</style>
@endauth
@section('content')
<!-- Hero Section -->
<div class="hero-section relative bg-gradient-to-r from-blue-900 to-blue-800 overflow-hidden">
    <!-- Background Images -->
    <div class="hero-bg active" style="background-image: url('https://images.unsplash.com/photo-1499750310107-5fef28a66643')"></div>
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97')"></div>
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1555066931-4365d14bab8c')"></div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/95 to-blue-800/95 mix-blend-multiply"></div>

    <!-- Content -->
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center hero-content">
                <h1 class="hero-title text-4xl font-extrabold tracking-tight text-white/90 sm:text-4xl lg:text-5xl xl:text-6xl">
                    <span class="block">Chia sẻ kiến thức,</span>
                    <span class="block mt-4">kết nối cộng đồng</span>
                </h1>
                <p class="mt-8 max-w-[46rem] mx-auto text-2xl text-blue-100/90 font-light">
                    <span class="animate-typing">Nơi chia sẻ kiến thức, kinh nghiệm và kết nối với cộng đồng lập trình viên Việt Nam.</span>
                </p>
                <div class="mt-12 flex justify-center gap-4">
                    <a href="{{ route('questions.create') }}"
                        class="inline-flex items-center px-10 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-blue-700 hover:bg-blue-800 transition-all duration-200 transform hover:scale-105 hover:shadow-lg floating">
                        <span class="mr-2">Đặt câu hỏi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('blog') }}"
                        class="inline-flex items-center px-10 py-4 border border-white/80 text-lg font-medium rounded-lg text-white/90 hover:bg-white/90 hover:text-blue-800 transition-all duration-200">
                        Khám phá bài viết
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="hero-pagination">
        <div class="hero-pagination-dot active" data-index="0"></div>
        <div class="hero-pagination-dot" data-index="1"></div>
        <div class="hero-pagination-dot" data-index="2"></div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <main class="lg:col-span-3 space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-bold text-gray-800">Bài viết mới nhất</h2>
                    <a href="{{ route('blog') }}" class="text-blue-700 hover:text-blue-800 font-medium flex items-center">
                        Xem tất cả
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid gap-8">
                    @foreach($posts as $post)
                    @include('client.partials.post-card', ['post' => $post])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            </main>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-8">
                <!-- Recent Posts -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Bài viết mới nhất</h3>
                    <div class="divide-y divide-gray-200">
                        @foreach($topPosts as $post)
                        <a href="{{ route('posts.show', $post->slug) }}"
                            class="block py-4 hover:bg-gray-50/80 transition-colors first:pt-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $post->image ?? '' }}"
                                    alt=""
                                    loading="lazy"
                                    class="h-12 w-12 rounded-lg object-cover">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-800 line-clamp-2 hover:text-blue-700 transition-colors">
                                        {{ $post->title }}
                                    </h4>
                                    <p class="text-xs text-gray-600 mt-1">
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
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backgrounds = document.querySelectorAll('.hero-bg');
        const dots = document.querySelectorAll('.hero-pagination-dot');
        let currentIndex = 0;

        function showSlide(index) {
            backgrounds.forEach(bg => bg.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            backgrounds[index].classList.add('active');
            dots[index].classList.add('active');
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % backgrounds.length;
            showSlide(currentIndex);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Click handlers for dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });
    });
</script>
@endpush
@endsection