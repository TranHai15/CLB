@extends('layouts.home')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/styles/atom-one-dark.min.css">
<style>
    #post-content {
        color: #2d3748;
        font-size: 1.125rem;
        line-height: 1.8;
        max-width: 65ch;
        margin: 0 auto;
    }

    #post-content h1 {
        font-size: 2.25rem;
        margin: 2rem 0 1rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.2;
    }

    #post-content h2 {
        font-size: 1.875rem;
        margin: 1.75rem 0 1rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.3;
    }

    #post-content h3 {
        font-size: 1.5rem;
        margin: 1.5rem 0 0.75rem;
        font-weight: 600;
        color: #1a202c;
    }

    #post-content h4 {
        font-size: 1.25rem;
        margin: 1.25rem 0 0.75rem;
        font-weight: 600;
        color: #1a202c;
    }

    #post-content p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    #post-content strong {
        font-weight: 600;
        color: #1a202c;
    }

    #post-content em {
        font-style: italic;
    }

    #post-content ul,
    #post-content ol {
        margin: 1.5rem 0;
        padding-left: 1.75rem;
    }

    #post-content ul {
        list-style-type: disc;
    }

    #post-content ol {
        list-style-type: decimal;
    }

    #post-content li {
        margin-bottom: 0.75rem;
        line-height: 1.6;
    }

    #post-content blockquote {
        border-left: 4px solid #4299e1;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #4a5568;
        background: #ebf8ff;
        border-radius: 0.5rem;
    }

    #post-content a {
        color: #3182ce;
        text-decoration: none;
        border-bottom: 1px solid #3182ce;
        transition: all 0.2s ease;
    }

    #post-content a:hover {
        color: #2c5282;
        border-bottom-color: #2c5282;
    }

    #post-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem auto;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: block;
    }

    #post-content pre {
        margin: 1.5rem 0;
        padding: 1.25rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        background-color: #1a202c;
        color: #e2e8f0;
        font-size: 0.875rem;
        margin: 1em 0;
        padding: 1em;
        border-radius: 8px;
        overflow-x: auto;
        color: #24292e;
        background-color: #f1f2f3;
        border: 1px solid #e5e5e5;
        position: relative;
        white-space: pre;
        word-wrap: normal;
    }

    #post-content pre code {
        display: block;
        padding: 0;
        overflow-x: auto;
        background: none;
        border: none;
        color: inherit;
        font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
        font-size: 14px;
        line-height: 1.45;
        tab-size: 4;
        text-align: left;
        white-space: pre;
        word-spacing: normal;
        word-break: normal;
        -webkit-hyphens: none;
        -ms-hyphens: none;
        hyphens: none;
    }

    #post-content code {
        padding: 0.2em 0.4em;
        margin: 0;
        font-size: 85%;
        background-color: rgba(27, 31, 35, 0.05);
        border-radius: 3px;
        color: #24292e;
        font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <article class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <!-- Categories and Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($post['categories'] as $category)
                    <a href="/category/{{ $category['slug'] }}"
                        class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                        {{ $category['name'] }}
                    </a>
                    @endforeach
                    @foreach($post['tags'] as $tag)
                    <a href="/tag/{{ $tag['slug'] }}"
                        class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-gray-200 transition">
                        #{{ $tag['name'] }}
                    </a>
                    @endforeach
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold mb-6">{{ $post['title'] }}</h1>

                <!-- Author Info -->
                <div class="flex items-center mb-8 border-b pb-6">
                    <a href="{{ $post['author']['link'] }}" class="block flex-shrink-0">
                        <img src="{{ $post['author']['avatar'] }}"
                            alt="{{ $post['author']['name'] }}"
                            class="h-14 w-14 rounded-full object-cover mr-4">
                    </a>
                    <div>
                        <a href="{{ $post['author']['link'] }}" class="text-lg font-medium text-gray-900 hover:underline">
                            {{ $post['author']['name'] }}
                        </a>
                        <div class="text-sm text-gray-600 mt-1">{{ $post['author']['bio'] }}</div>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <span>{{ \Carbon\Carbon::parse($post['createdAt'])->format('d/m/Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ number_format($post['views']) }} lượt xem</span>
                            <span class="mx-2">•</span>
                            <span id="readTime">5 phút đọc</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if(!empty($post['thumbnail']))
                <div class="mb-8">
                    <img src="{{ $post['thumbnail'] }}"
                        alt="Thumbnail của {{ $post['title'] }}"
                        class="w-full rounded-lg object-cover">
                </div>
                @endif

                <!-- Content -->
                <div class="max-w-none mb-8" id="post-content">
                    {!! $post['data'] !!}
                </div>
            </article>

            <!-- Comments Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6">Bình luận ({{ count($post['comments']) }})</h2>

                <!-- Comment Form -->
                <form class="mb-8">
                    <div class="mb-4">
                        <textarea
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="4"
                            placeholder="Viết bình luận của bạn..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Gửi bình luận
                    </button>
                </form>

                <!-- Comments List -->
                <div class="space-y-6">
                    @foreach($post['comments'] as $comment)
                    <div class="flex gap-4">
                        <img src="{{ $comment['user']['avatar'] }}"
                            alt="{{ $comment['user']['name'] }}"
                            class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-medium">{{ $comment['user']['name'] }}</h4>
                                <span class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $comment['content'] }}</p>
                            <div class="flex gap-4 mt-2">
                                <button class="text-sm text-gray-500 hover:text-blue-600">
                                    <i class="far fa-thumbs-up mr-1"></i>
                                    {{ $comment['likes'] }} thích
                                </button>
                                <button class="text-sm text-gray-500 hover:text-blue-600">Trả lời</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Related Posts -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-6">Bài viết liên quan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($post['related_posts'] as $relatedPost)
                    <div class="flex gap-4">
                        <img src="{{ $relatedPost['thumbnail'] }}"
                            alt="{{ $relatedPost['title'] }}"
                            class="w-32 h-24 object-cover rounded-lg">
                        <div>
                            <h3 class="font-medium text-lg mb-2 line-clamp-2 hover:text-blue-600">
                                <a href="/posts/{{ $relatedPost['id'] }}">{{ $relatedPost['title'] }}</a>
                            </h3>
                            <div class="flex items-center text-sm text-gray-500">
                                <span>{{ $relatedPost['author'] }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ \Carbon\Carbon::parse($relatedPost['created_at'])->format('d/m/Y') }}</span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ number_format($relatedPost['views']) }} lượt xem
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Table of Contents Sidebar -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                <h3 class="text-lg font-bold mb-4">Mục lục</h3>
                <nav id="table-of-contents" class="space-y-2">
                    <!-- Will be populated by JavaScript -->
                </nav>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate table of contents
        const content = document.getElementById('post-content');
        const toc = document.getElementById('table-of-contents');
        const headings = content.querySelectorAll('h2');

        headings.forEach((heading, index) => {
            // Add ID to heading if not exists
            if (!heading.id) {
                heading.id = `heading-${index}`;
            }

            // Create TOC item
            const link = document.createElement('a');
            link.href = `#${heading.id}`;
            link.textContent = heading.textContent;
            link.className = 'block text-gray-600 hover:text-blue-600 py-1 transition';

            // Add click event for smooth scroll
            link.addEventListener('click', (e) => {
                e.preventDefault();
                heading.scrollIntoView({
                    behavior: 'smooth'
                });
            });

            toc.appendChild(link);
        });

        // Add syntax highlighting to code blocks
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    });
</script>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
@endpush
@endsection