@extends('layouts.home')



@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/styles/atom-one-dark.min.css">
<style>
    #post-content {
        color: #fff;
        font-size: 1.125rem;
        line-height: 1.8;
        max-width: 85ch;
        margin: 0 auto;
    }

    h1 {
        font-size: 2.25rem !important;
        margin: 2rem 0 1rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.2;
    }

    h2 {
        font-size: 1.875rem !important;
        margin: 1.75rem 0 1rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.3;
    }

    h3 {
        font-size: 1.5rem !important;
        margin: 1.5rem 0 0.75rem;
        font-weight: 600;
        color: #1a202c;
    }

    h4 {
        font-size: 1.25rem !important;
        margin: 1.25rem 0 0.75rem;
        font-weight: 600;
        color: #1a202c;
    }

    #post-content p {
        margin-bottom: 1.5rem !important;
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

    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
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
</style>

@endpush

@section('content')

<div class="container mx-auto max-w-7xl px-4 py-8 ">
    <div class="flex flex-col lg:flex-row gap-8 ">
        <!-- Main Content -->
        <div class="lg:w-3/4 ">
            <article class="bg-white rounded-lg shadow-lg p-6 mb-8 post-card">
                <!-- Categories and Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($post->category)
                    <a href="{{ route('category.show', $post->category->slug) }}"
                        class="category-badge inline-block text-xs font-semibold px-3 py-1.5 rounded-full transition-colors duration-200">
                        {{ $post->category->name }}
                    </a>
                    @endif

                    <!-- @foreach($post->tags as $tag)
                    <a href="/tag/{{ $tag->slug }}"
                        class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-gray-200 transition">
                        #{{ $tag->name }}
                    </a>
                    @endforeach -->
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold mb-6 text-white">{{ $post->title }}</h1>

                <!-- Author Info -->
                <div class="flex items-center mb-8 border-b pb-6">
                    <a href="{{ $post->creator->ids }}" class="block flex-shrink-0">
                        <img src="{{ $post->creator->avatar_url }}"
                            alt="{{ $post->creator->name }}"
                            class="h-14 w-14 rounded-full object-cover mr-4">
                    </a>
                    <div>
                        <a href="{{ $post->creator->id }}" class="text-lg font-medium text-white hover:underline">
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
                <div class="max-w-none mb-8 text-white" id="post-content">
                    {!! $post->content !!}
                </div>

                <!-- Like Button -->
                <div class="mt-6 flex items-center space-x-4 border-t pt-6">
                    @auth
                    <button id="post-like-btn" data-post-id="{{ $post->id }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg id="like-icon" class="-ml-0.5 mr-2 h-4 w-4 {{ $post->is_liked ? 'text-red-500 fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                        </svg>
                        <span>
                            Thích <span id="post-likes-count">{{ $post->likes }}</span>
                        </span>
                        <button type="button" onclick="toggleCommentForm()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Bình luận
                        </button>
                    </button>
                    @else
                    <form action="{{ route('questions.show', $post->slug) }}" method="post">
                        @csrf

                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            Thích <span class="ml-1">{{ $post->likes }}</span>
                        </button>
                    </form>
                    <form action="{{ route('questions.show', $post->slug) }}" method="post">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Bình luận
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
                <div id="commentForm" class="mt-4 hidden">
                    @auth
                    <form id="comment-form" action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="post">
                        <div>
                            <label for="comment" class="sr-only">Câu trả lời</label>
                            <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Viết câu trả lời của bạn..."></textarea>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Gửi câu trả lời
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-4">
                        <p class="text-gray-600 mb-3">Vui lòng đăng nhập để bình luận</p>
                        <form action="{{ route('questions.show', $post->slug) }}" method="post">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                Đăng nhập
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </article>

            <!-- Comments Section -->
            <div id="comments-container" class="space-y-6 ">
                @foreach($post->comments as $comment)
                @include('client.partials.comment', ['comment' => $comment])
                @endforeach
            </div>
        </div>

        <!-- Table of Contents Sidebar -->
        <div class="lg:w-1/4 ">
            <div class="rounded-lg shadow-lg p-6 sticky top-4 post-card text-white">
                <h3 class="text-lg font-bold mb-4  text-[var(--primary-color)] ">Mục lục</h3>
                <nav id="table-of-contents" class="space-y-2  text-[var(--primary-color)]">
                    <!-- Will be populated by JavaScript -->
                </nav>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    <div class=" rounded-lg shadow-lg p-6 mt-10 ">
        <h2 class="text-2xl font-bold mb-6 text-white">Bài viết liên quan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPosts as $relatedPost)
            <div class="post-card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                <a href="/posts/{{ $relatedPost->slug }}">
                    <img src="{{ $relatedPost->image }}"
                        alt="{{ $relatedPost->title }}"
                        class="w-full h-48 object-cover">
                </a>
                <div class="p-4">
                    <a href="/posts/{{ $relatedPost->slug }}">
                        <h3 class="font-medium text-lg mb-2 line-clamp-2 text-white hover:text-[var(--primary-color)]">
                            {{ $relatedPost->title }}
                        </h3>
                    </a>
                    <div class="flex items-center text-sm text-white mb-2">
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
    function toggleCommentForm() {
        const form = document.getElementById('commentForm');
        form.classList.toggle('hidden');
    }
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

        // AJAX for post like
        $('#post-like-btn').on('click', function() {
            const postId = "{{ $post->id}}";

            $.ajax({
                url: `/posts/${postId}/like`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#post-likes-count').text(response.likes);

                        if (response.liked) {
                            $('#like-icon').addClass('text-red-500 fill-current');
                        } else {
                            $('#like-icon').removeClass('text-red-500 fill-current');
                        }
                    }
                }
            });
        });

        // AJAX for comment submission
        $('#comment-form').on('submit', function(e) {
            e.preventDefault();

            const postId = "{{ $post->id }}";
            const commentText = $(this).find('textarea[name="comment"]').val();

            if (!commentText.trim()) {
                return;
            }

            $.ajax({
                url: `/posts/${postId}/comments`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    comment: commentText
                },
                success: function(response) {
                    if (response.success) {
                        // Add the new comment to the top of the comments list
                        $('#comments-container').prepend(response.html);

                        // Clear the comment form
                        $('#comment-form textarea').val('');

                        // Update the comment count
                        $('#comments-count').text(parseInt($('#comments-count').text()) + 1);

                        // Initialize the new comment's functionality
                        initCommentFunctionality();
                    }
                }
            });
        });

        // Handle comment like button clicks
        function initCommentFunctionality() {
            // Comment like functionality
            $('.comment-like-btn').off('click').on('click', function() {
                const commentId = $(this).data('comment-id');
                const likeCountElement = $(this).find('.like-count');

                $.ajax({
                    url: `/comments/${commentId}/like`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            likeCountElement.text(response.likes);
                            if (response.liked) {
                                $(this).addClass('text-red-500 fill-current');
                            } else {
                                $(this).removeClass('text-red-500 fill-current');
                            }
                        }
                    }
                });
            });

            // Toggle reply form
            $('.reply-toggle-btn').off('click').on('click', function() {
                const commentId = $(this).data('comment-id');
                $(`#replyForm${commentId}`).toggleClass('hidden');
            });

            // Reply form submission
            $('.reply-form').off('submit').on('submit', function(e) {
                e.preventDefault();

                const commentId = $(this).data('comment-id');
                const replyText = $(this).find('textarea[name="comment"]').val();

                if (!replyText.trim()) {
                    return;
                }

                $.ajax({
                    url: `/comments/${commentId}/reply`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        comment: replyText
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Add the new reply after the parent comment
                            $(`#comment-${commentId}`).after(response.html);

                            // Clear the reply form and hide it
                            $(`#replyForm${commentId} textarea`).val('');
                            $(`#replyForm${commentId}`).addClass('hidden');

                            // Update the comment count
                            $('#comments-count').text(parseInt($('#comments-count').text()) + 1);

                            // Initialize the new reply's functionality
                            initCommentFunctionality();
                        }
                    }
                });
            });
        }

        // Initialize comment functionality
        initCommentFunctionality();
    });
</script>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
@endpush
@endsection