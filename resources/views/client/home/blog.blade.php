@extends('layouts.home')
<style>
    :root {
        --primary-color: #f59e0b;
        /* Amber-500 for Bee IT accent */
        --primary-hover-color: #d97706;
        /* Amber-600 */
        --secondary-color: #0ea5e9;
        /* Sky-500 */
        --dark-bg: #111827;
        /* Gray-900 */
        --dark-card-bg: #1f2937;
        /* Gray-800 */
        --dark-card-bg-hover: #374151;
        /* Gray-700 */
        --text-light: #f3f4f6;
        /* Gray-100 */
        --text-medium: #9ca3af;
        /* Gray-400 */
        --text-dark: #1f2937;
        /* Gray-800 */
        /* Assuming --font-secondary is defined elsewhere, e.g., in layouts.home */
        /* --font-primary: 'Inter', sans-serif; */
        /* --font-secondary: 'Orbitron', sans-serif; /* Example for a techy title font */
    }

    body {
        background-color: var(--dark-bg);
        color: var(--text-light);
    }



    @keyframes typing {
        0% {
            width: 0;
        }

        50% {
            width: 100%;
        }

        70% {
            width: 100%;
        }

        /* Pause before deleting */
        100% {
            width: 0;
        }
    }

    @keyframes blink {
        50% {
            border-color: transparent;
        }
    }

    .animate-typing {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        border-right: 3px solid var(--primary-color);
        animation: typing 4s steps(45, end) infinite, blink 0.75s step-end infinite;
        color: var(--primary-color);
        /* Make typing text stand out */
        font-weight: 500;
    }

    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        /* 12px */
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid transparent;
    }

    .post-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-color);
        background-color: var(--dark-card-bg-hover);
    }

    .post-card .post-title {
        color: var(--text-light);
        transition: color 0.3s ease;
    }

    .post-card:hover .post-title {
        color: var(--primary-color);
    }

    .category-badge {
        transition: all 0.2s ease;
        background-color: var(--primary-color);
        color: var(--text-dark);
    }

    .category-badge:hover {
        transform: scale(1.05);
        background-color: var(--primary-hover-color);
    }

    .hero-title {
        font-family: var(--font-secondary, 'Poppins', sans-serif);
        /* Fallback font */
        letter-spacing: -0.02em;
        font-weight: 800;
        /* Bolder title */
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .hero-section {
        height: 100vh;
        min-height: 700px;
        /* Increased min-height */
        position: relative;
        overflow: hidden;
        /* background: linear-gradient(45deg, #0f0c29, #302b63, #24243e); */
        background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #0f172a);
        background-size: 400% 400%;
        animation: gradientBG 25s ease infinite;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
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
        transition: opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1), transform 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        /* Smoother transition */
        opacity: 0;
        transform: scale(1.05);
        /* Slight zoom out for inactive */
    }

    .hero-bg.active {
        opacity: 1;
        transform: scale(1);
        /* Normal scale for active */
    }

    .hero-overlay {
        background: rgba(17, 24, 39, 0.8);
        /* Darker overlay: Gray-900 with opacity */
    }

    .hero-pagination {
        position: absolute;
        bottom: 2.5rem;
        /* Slightly higher */
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
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .hero-pagination-dot.active {
        background: var(--primary-color);
        transform: scale(1.3);
        box-shadow: 0 0 10px var(--primary-color);
    }

    .floating {
        animation: floating 3.5s ease-in-out infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-12px);
        }

        /* Reduced floating height */
        100% {
            transform: translateY(0px);
        }
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: #ffffff;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px -5px var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover-color);
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 20px -5px var(--primary-color);
    }

    .btn-secondary {
        border-color: rgba(255, 255, 255, 0.7);
        color: var(--text-light);
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.9);
        color: var(--dark-bg);
        border-color: transparent;
        transform: translateY(-2px);
    }

    .main-content-area {
        background-color: var(--dark-bg);
        /* Ensure main content bg is dark */
    }

    .section-title {
        color: var(--text-light);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        display: inline-block;
    }

    .sidebar-widget {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #374151;
        /* Gray-700 border */
    }

    .sidebar-widget h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .sidebar-post-item:hover {
        background-color: var(--dark-card-bg-hover);
    }

    .sidebar-post-item img {
        transition: transform 0.3s ease;
    }

    .sidebar-post-item:hover img {
        transform: scale(1.05);
    }

    /* Pagination styling */
    .pagination {
        /* Add custom styles for pagination if needed, Tailwind usually handles this well */
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .pagination .page-link {
        color: var(--text-medium);
        background-color: var(--dark-card-bg);
        border: 1px solid #374151;
    }

    .pagination .page-link:hover {
        color: var(--text-light);
        background-color: var(--dark-card-bg-hover);
        border-color: var(--primary-color);
    }
</style>

@section('content')

<div class="container mx-auto max-w-7xl px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <main class="lg:col-span-3 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold text-gray-900">Bài viết mới nhất</h2>

            </div>

            <div class="grid gap-8">
                @forelse($posts as $post)
                @include('client.partials.post-card', ['post' => $post])
                @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-300">Không có bài viết nào</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Hiện tại chưa có bài viết nào được đăng. Quay lại sau nhé!
                    </p>
                </div>
                @endforelse
            </div>
            @if ($posts->hasPages())
            <div class="mt-12 pagination">
                {{ $posts->links() }}
            </div>
            @endif
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