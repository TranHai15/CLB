<div class="border-b border-gray-200  last:border-0 last:pb-0 bg-white rounded-lg shadow-sm  p-5" id="comment-{{ $comment->id }}">
    <div class="flex items-center space-x-3">
        <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-100" src="{{ $comment->creator->avatar_url }}" alt="{{ $comment->creator->name }}">
        <div>
            <p class="text-sm font-medium text-gray-900">{{ $comment->creator->name }}</p>
            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <div class="mt-4 prose max-w-none bg-gray-50 p-4 rounded-lg">
        @if(strpos($comment->comment, '@') === 0)
        {!! preg_replace('/@(\w+)/', '<span class="text-blue-600 font-medium">@$1</span>', $comment->comment, 1) !!}
        @else
        {!! $comment->comment !!}
        @endif
    </div>

    <div class="mt-4 flex items-center space-x-4 bg-reg-400">
        @auth
        <button type="button" class="comment-like-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            data-comment-id="{{ $comment->id }}">
            <span>
                Thích <span class="like-count" id="comment_like_count">{{ $comment->like_count }}</span>
            </span>
        </button>
        @else
        <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
            <span>
                Thích <span>{{ $comment->like_count }}</span>
            </span>
        </a>
        @endauth

        <button type="button" class="reply-toggle-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200" data-comment-id="{{ $comment->id }}">
            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            Phản hồi
        </button>

        @auth
        @if(Auth::id() === $comment->creator->id)
        <button class="comment-delete-btn inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-red-500 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200" data-comment-id="{{ $comment->id }}">
            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Xóa
        </button>
        @endif
        @endauth
    </div>

    <!-- Reply Form (Hidden by default) -->
    <div id="replyForm{{ $comment->id }}" class="mt-4 mb-4 hidden">
        @auth
        <form class="reply-form bg-gray-50 p-4 rounded-lg" data-comment-id="{{ $comment->id }}">
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
        <div class="text-center py-3 bg-gray-50 rounded-lg">
            <p class="text-gray-600 text-sm mb-2">Vui lòng đăng nhập để phản hồi</p>
            <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                Đăng nhập
            </a>
        </div>
        @endauth
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Function to handle comment deletion
        function handleCommentDelete(button) {
            const $button = $(button);

            // Disable button to prevent multiple clicks
            if ($button.prop('disabled')) return;
            $button.prop('disabled', true);

            const commentId = $button.data('comment-id');
            const commentElement = $button.closest('[id^="comment-"]');

            if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                $.ajax({
                    url: `/comments/${commentId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove the comment from the DOM
                            commentElement.fadeOut(300, function() {
                                $(this).remove();
                                // Update comment count
                                const currentCount = parseInt($('#comments-count').text());
                                $('#comments-count').text(currentCount - 1);
                            });
                        } else {
                            alert(response.message || 'Có lỗi xảy ra khi xóa bình luận');
                            $button.prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        alert(response?.message || 'Có lỗi xảy ra khi xóa bình luận');
                        $button.prop('disabled', false);
                    }
                });
            } else {
                $button.prop('disabled', false);
            }
        }

        // Sử dụng event delegation để xử lý click cho tất cả nút xóa
        $(document).on('click', '.comment-delete-btn', function(e) {
            e.preventDefault();
            handleCommentDelete(this);
        });

        // Nếu bạn có hàm để thêm comment mới, hãy gọi handleCommentDelete cho nút xóa mới
        // Ví dụ:
        // function addNewComment(commentHtml) {
        //     $('#comments-container').append(commentHtml);
        //     // Không cần gắn lại sự kiện vì đã dùng event delegation
        // }
    });
</script>
@endpush