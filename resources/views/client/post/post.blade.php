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
                    @if($post->category)
                    <a href="/category/{{ $post->category->slug }}"
                        class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                        {{ $post->category->name }}
                    </a>
                    @endif

                    @foreach($post->tags as $tag)
                    <a href="/tag/{{ $tag->slug }}"
                        class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-gray-200 transition">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold mb-6">{{ $post->title }}</h1>

                <!-- Author Info -->
                <div class="flex items-center mb-8 border-b pb-6">
                    <a href="{{ $post->creator->ids }}" class="block flex-shrink-0">
                        <img src="{{ $post->creator->avatar_url }}"
                            alt="{{ $post->creator->name }}"
                            class="h-14 w-14 rounded-full object-cover mr-4">
                    </a>
                    <div>
                        <a href="{{ $post->creator->id }}" class="text-lg font-medium text-gray-900 hover:underline">
                            {{ $post->creator->name }}
                        </a>

                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <span>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ number_format($post->views) }} lượt xem</span>
                            <span class="mx-2">•</span>
                            <span id="readTime">5 phút đọc</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if(!empty($post->image))
                <div class="mb-8">
                    <img src="{{ $post->image }}"
                        alt="Thumbnail của {{ $post->title }}"
                        class="w-full rounded-lg object-cover">
                </div>
                @endif

                <!-- Content -->
                <div class="max-w-none mb-8" id="post-content">
                    {!! $post->content !!}
                </div>

                <!-- Like Button -->
                <div class="mt-6 flex items-center space-x-4 border-t pt-6">
                    @auth
                    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="post">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4 {{ DB::table('user_likes')->where('user_id', Auth::id())->where('post_id', $post->id)->exists() ? 'text-red-500 fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            <span>
                                Thích <span>{{ $post->likes }}</span>
                            </span>
                        </button>
                    </form>
                    @else
                    <form action="{{ route('login') }}" method="get">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            <span>
                                Thích <span>{{ $post->likes }}</span>
                            </span>
                        </button>
                    </form>
                    @endauth

                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $post->views }} lượt xem
                        </span>
                    </div>
                </div>
            </article>

            <!-- Comments Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6">Bình luận ({{ $post->comments->count() }})</h2>

                <!-- Comment Form -->
                @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
                    @csrf
                    <input type="hidden" name="type" value="post">
                    <div class="mb-4">
                        <textarea
                            name="comment"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="4"
                            placeholder="Viết bình luận của bạn..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Gửi bình luận
                    </button>
                </form>
                @else
                <div class="text-center py-4 mb-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-600 mb-3">Vui lòng đăng nhập để bình luận</p>
                    <form action="{{ route('login') }}" method="get">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Đăng nhập
                        </button>
                    </form>
                </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-6">
                    @foreach($post->comments as $comment)
                    <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0" id="comment-{{ $comment->id }}">
                        <div class="flex items-center space-x-3">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $comment->creator->avatar_url }}" alt="{{ $comment->creator->name }}">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $comment->creator->name }}</p>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="mt-4 prose max-w-none">
                            @if(strpos($comment->comment, '@') === 0)
                            {!! preg_replace('/@(\w+)/', '<span class="text-blue-600 font-medium">@$1</span>', $comment->comment, 1) !!}
                            @else
                            {!! $comment->comment !!}
                            @endif
                        </div>

                        <div class="mt-4 flex items-center space-x-4">
                            @auth
                            <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="type" value="comment">
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <span>
                                        Thích <span>{{ $comment->like_count }}</span>
                                    </span>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('login') }}" method="get">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <span>
                                        Thích <span>{{ $comment->like_count }}</span>
                                    </span>
                                </button>
                            </form>
                            @endauth

                            <button type="button" onclick="toggleReplyForm('{{ $comment->id }}')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Phản hồi
                            </button>
                        </div>

                        <!-- Reply Form (Hidden by default) -->
                        <div id="replyForm{{ $comment->id }}" class="mt-4 hidden">
                            @auth
                            <form action="{{ route('comments.storeReply', $comment) }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="post">
                                <div>
                                    <textarea name="comment" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Viết phản hồi của bạn..."></textarea>
                                </div>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        Gửi phản hồi
                                    </button>
                                </div>
                            </form>
                            @else
                            <div class="text-center py-3">
                                <p class="text-gray-600 text-sm mb-2">Vui lòng đăng nhập để phản hồi</p>
                                <form action="{{ route('login') }}" method="get">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        Đăng nhập
                                    </button>
                                </form>
                            </div>
                            @endauth
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

    <!-- Related Posts -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Bài viết liên quan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPosts as $relatedPost)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                <a href="/posts/{{ $relatedPost->slug }}">
                    <img src="{{ $relatedPost->image }}"
                        alt="{{ $relatedPost->title }}"
                        class="w-full h-48 object-cover">
                </a>
                <div class="p-4">
                    <a href="/posts/{{ $relatedPost->slug }}">
                        <h3 class="font-medium text-lg mb-2 line-clamp-2 hover:text-blue-600">
                            {{ $relatedPost->title }}
                        </h3>
                    </a>
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <img src="{{ $relatedPost->creator->avatar_url }}"
                            alt="{{ $relatedPost->creator->name }}"
                            class="w-6 h-6 rounded-full mr-2">
                        <span>{{ $relatedPost->creator->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ \Carbon\Carbon::parse($relatedPost->created_at)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($relatedPost->views) }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            {{ $relatedPost->likes }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
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

    // Toggle reply form function
    function toggleReplyForm(commentId) {
        const form = document.getElementById('replyForm' + commentId);
        form.classList.toggle('hidden');
    }
</script>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
@endpush
@endsection