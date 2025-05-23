@extends('layouts.home')
<style>
    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;

    }



    .post-card .post-title {
        color: var(--text-light);

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
@section('content')
<div class="space-y-8 container mx-auto max-w-7xl px-4 py-8">
    <!-- Question Header -->
    <div class="rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300  post-card ">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img class="h-10 w-10 rounded-full object-cover text-white" src="{{ $question->creator->avatar_url  }}" alt="{{ $question->creator->name }}">
                    <div>
                        <p class="text-sm font-medium  text-white">{{ $question->creator->name }}</p>
                        <p class="text-sm text-gray-500">{{ $question->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @auth
                    @if(auth()->id() === $question->creator->id)
                    <a href="{{ route('questions.edit', $question->slug) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Sửa
                    </a>
                    <button type="button" id="delete-question-btn" data-question-id="{{ $question->id }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Xóa
                    </button>
                    @endif
                    @endauth
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $question->category->name }}
                    </span>
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $question->views }} lượt xem
                    </span>
                </div>
            </div>

            <h1 class="mt-4 text-2xl font-bold post-title">{{ $question->title }}</h1>

            <div class="mt-4 prose max-w-none">
                {!! $question->content !!}
            </div>

            <div class="mt-6 flex items-center space-x-4">
                @auth
                <button id="post-like-btn" data-post-id="{{ $question->id }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg id="like-icon" class="-ml-0.5 mr-2 h-4 w-4 {{ \Illuminate\Support\Facades\DB::table('user_likes')->where('user_id', auth()->id())->where('post_id', $question->id)->exists() ? 'text-red-500 fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                    </svg>
                    <span>
                        Thích <span id="post-likes-count">{{ $question->likes }}</span>
                    </span>
                </button>
                @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                    </svg>
                    <span>
                        Thích <span>{{ $question->likes }}</span>
                    </span>
                </a>
                @endauth

                <button type="button" onclick="toggleCommentForm()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Bình luận
                </button>
            </div>

            <!-- Comment Form (Hidden by default) -->
            <div id="commentForm" class="mt-4 hidden">
                @auth
                <form id="comment-form" action="{{ route('comments.store', $question->id) }}" method="POST">
                    @csrf
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
                    <form action="{{ route('questions.show',$question->slug) }}" method="get">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Đăng nhập
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Answers Section -->
    <div id="comments-container" class="space-y-6">
        @foreach($question->comments as $comment)
        @include('client.partials.comment', ['comment' => $comment])
        @endforeach
    </div>

    <!-- Related Questions -->
    <div class=" rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 post-card">
        <div class="p-6">
            <h3 class="text-lg font-medium text-white">Câu hỏi liên quan</h3>
            <div class="mt-4 space-y-4 divide-y divide-gray-100">
                @foreach($relatedQuestions as $relatedQuestion)
                <div class="flex items-center justify-between pt-4 first:pt-0">
                    <a href="{{ route('questions.show', $relatedQuestion->slug) }}" class="text-sm font-medium text-white hover:text-blue-600 transition-colors duration-200">
                        {{ $relatedQuestion->title }}
                    </a>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            {{ $relatedQuestion->comments->count() }}
                        </span>
                        <span class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $relatedQuestion->views }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleCommentForm() {
        const form = document.getElementById('commentForm');
        form.classList.toggle('hidden');
    }

    // Handle reply button clicks
    $('#post-like-btn').on('click', function() {
        const postId = "{{ $question->id}}";

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

        const postId = "{{ $question->id }}";
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

    // Handle question deletion
    $('#delete-question-btn').on('click', function() {
        if (!confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
            return;
        }

        const questionId = $(this).data('question-id');
        const $button = $(this);

        $.ajax({
            url: `/questions/${questionId}`,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '/questions';
                } else {
                    alert(response.message || 'Có lỗi xảy ra khi xóa câu hỏi');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert(response?.message || 'Có lỗi xảy ra khi xóa câu hỏi');
            }
        });
    });
</script>
@endpush
@endsection