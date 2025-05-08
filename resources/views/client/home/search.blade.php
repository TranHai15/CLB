@extends('layouts.home')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            @if(request('search'))
            <i class="fas fa-search text-blue-500 mr-2"></i>Kết quả tìm kiếm cho: "{{ request('search') }}"
            @elseif(request('category'))
            <i class="fas fa-folder text-blue-500 mr-2"></i>Danh mục: {{ request('category') }}
            @elseif(request('tag'))
            <i class="fas fa-tags text-blue-500 mr-2"></i>Tag: {{ request('tag') }}
            @endif
        </h1>
        <div class="flex items-center gap-4 text-sm text-gray-500">
            <span><i class="fas fa-list-ul mr-2"></i>Tổng số: {{ $posts->total() }} kết quả</span>
            @if(request('search'))
            <span><i class="fas fa-clock mr-2"></i>Thời gian tìm kiếm: {{ number_format(microtime(true) - LARAVEL_START, 2) }}s</span>
            @endif
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Bộ lọc tìm kiếm</h2>

                <!-- Search Form -->
                <form action="{{ route('home.search') }}" method="GET" class="mb-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nhập từ khóa...">
                    </div>

                    <!-- Type Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Loại nội dung</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="type[]" value="post"
                                    {{ in_array('post', request('type', [])) ? 'checked' : '' }}
                                    class="rounded text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Bài viết</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="type[]" value="question"
                                    {{ in_array('question', request('type', [])) ? 'checked' : '' }}
                                    class="rounded text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Câu hỏi</span>
                            </label>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories ?? [] as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort Options -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp theo</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                            <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Lượt xem nhiều nhất</option>
                            <option value="likes" {{ request('sort') == 'likes' ? 'selected' : '' }}>Lượt thích nhiều nhất</option>
                        </select>
                    </div>

                    <!-- Time Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Thời gian</label>
                        <select name="time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tất cả thời gian</option>
                            <option value="day" {{ request('time') == 'day' ? 'selected' : '' }}>Hôm nay</option>
                            <option value="week" {{ request('time') == 'week' ? 'selected' : '' }}>Tuần này</option>
                            <option value="month" {{ request('time') == 'month' ? 'selected' : '' }}>Tháng này</option>
                            <option value="year" {{ request('time') == 'year' ? 'selected' : '' }}>Năm nay</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Áp dụng bộ lọc
                    </button>
                </form>

                <!-- Popular Tags -->
                <div class="border-t pt-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Tags phổ biến</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags ?? [] as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}"
                            class="inline-flex items-center bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm hover:bg-gray-200 transition-colors">
                            <i class="fas fa-tag text-xs mr-1"></i>
                            {{ $tag->name }}
                            <span class="ml-1 text-xs text-gray-500">({{ $tag->posts_count }})</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4">
            <!-- Search Results -->
            <div class="space-y-6">
                @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">
                    <div class="flex flex-col">
                        <!-- Post Type Badge -->
                        <div class="mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $post->type === 'question' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                <i class="fas {{ $post->type === 'question' ? 'fa-question-circle' : 'fa-newspaper' }} mr-2"></i>
                                {{ $post->type === 'question' ? 'Câu hỏi' : 'Bài viết' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">
                            <a href="{{ $post->type === 'question' ? route('questions.show', $post->slug) : route('posts.show', $post->slug) }}"
                                class="hover:text-blue-600 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <!-- Content Preview -->
                        @if($post->content)
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($post->content), 200) }}
                        </p>
                        @endif

                        <!-- Meta Information -->
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            <!-- Author -->
                            @if($post->user)
                            <div class="flex items-center">
                                <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}"
                                    alt="{{ $post->user->name }}"
                                    class="w-6 h-6 rounded-full mr-2">
                                <a href="{{ route('user.show', $post->user->id) }}"
                                    class="hover:text-blue-600 transition-colors font-medium">
                                    {{ $post->user->name }}
                                </a>
                            </div>
                            @endif

                            <!-- Category -->
                            @if($post->category)
                            <span class="inline-flex items-center bg-gray-100 px-3 py-1 rounded-full">
                                <i class="fas fa-folder text-gray-500 mr-2"></i>
                                <a href="{{ route('category.show', $post->category->slug) }}"
                                    class="hover:text-blue-600 transition-colors">
                                    {{ $post->category->name }}
                                </a>
                            </span>
                            @endif

                            <!-- Tags -->
                            @if($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->slug) }}"
                                    class="inline-flex items-center bg-blue-50 text-blue-600 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-tag text-xs mr-1"></i>
                                    {{ $tag->name }}
                                </a>
                                @endforeach
                            </div>
                            @endif

                            <!-- Stats -->
                            <div class="flex items-center gap-4 ml-auto">
                                <!-- Views -->
                                <span class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-eye text-gray-500 mr-2"></i>
                                    {{ number_format($post->views) }}
                                </span>

                                <!-- Likes -->
                                <span class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-heart text-red-500 mr-2"></i>
                                    {{ number_format($post->likes_count) }}
                                </span>

                                <!-- Date -->
                                <span class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-calendar text-gray-500 mr-2"></i>
                                    {{ $post->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <div class="text-gray-500 text-lg">
                        <i class="fas fa-search mb-4 text-4xl text-gray-400"></i>
                        <p class="text-xl">Không tìm thấy kết quả phù hợp</p>
                        <p class="text-sm mt-2">Hãy thử tìm kiếm với từ khóa khác</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom pagination styles */
    .pagination {
        @apply flex justify-center space-x-2;
    }

    .pagination>* {
        @apply px-4 py-2 rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow;
    }

    .pagination .active {
        @apply bg-blue-500 text-white;
    }
</style>
@endpush