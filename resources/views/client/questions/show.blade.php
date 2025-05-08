@extends('layouts.home')

@section('content')
<div class="space-y-8 container mx-auto max-w-7xl px-4 py-8">
    <!-- Question Header -->
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $question->creator->avatar_url  }}" alt="{{ $question->creator->name }}">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $question->creator->name }}</p>
                        <p class="text-sm text-gray-500">{{ $question->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
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

            <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $question->title }}</h1>

            <div class="mt-4 prose max-w-none">
                {!! $question->content !!}
            </div>

            <div class="mt-6 flex items-center space-x-4">
                @auth
                <form action="{{ route('posts.like', $question->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="-ml-0.5 mr-2 h-4 w-4 {{ DB::table('user_likes')->where('user_id', Auth::id())->where('post_id', $question->id)->exists() ? 'text-red-500 fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                        </svg>
                        <span>
                            Thích <span>{{ $question->likes }}</span>
                        </span>
                    </button>

                </form>
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
                <form action="{{ route('comments.store', $question) }}" method="POST">
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
                    <form action="{{ route('auth.demo') }}" method="get">
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
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">{{ count($question->comments) }} câu trả lời</h2>

            <div class="mt-6 space-y-6">
                @foreach($question->comments as $answer)
                <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0" id="comment-{{ $answer->id }}">
                    <div class="flex items-center space-x-3">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ $answer->creator->avatar_url }}" alt="{{ $answer->creator->name }}">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $answer->creator->name }}</p>
                            <p class="text-sm text-gray-500">{{ $answer->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="mt-4 prose max-w-none">
                        @if(strpos($answer->comment, '@') === 0)
                        {!! preg_replace('/@(\w+)/', '<span class="text-blue-600 font-medium">@$1</span>', $answer->comment, 1) !!}
                        @else
                        {!! $answer->comment !!}
                        @endif
                    </div>

                    <div class="mt-4 flex items-center space-x-4">
                        @auth
                        <form action="{{ route('comments.like', $answer->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">

                                <span>
                                    Thích <span>{{ $answer->like_count }}</span>
                                </span>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                            <span>
                                Thích <span>{{ $answer->like_count }}</span>
                            </span>
                        </a>
                        @endauth

                        <button type="button" onclick="toggleReplyForm('{{ $answer->id }}')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Phản hồi
                        </button>
                    </div>

                    <!-- Reply Form (Hidden by default) -->
                    <div id="replyForm{{ $answer->id }}" class="mt-4 hidden">
                        @auth
                        <form action="{{ route('comments.storeReply', $answer) }}" method="POST">
                            @csrf
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
                            <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                Đăng nhập
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Related Questions -->
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Câu hỏi liên quan</h2>
            <div class="mt-4 space-y-4 divide-y divide-gray-100">
                @foreach($relatedQuestions as $relatedQuestion)
                <div class="flex items-center justify-between pt-4 first:pt-0">
                    <a href="{{ route('questions.show', $relatedQuestion->slug) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors duration-200">
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

    function toggleReplyForm(answerId) {
        const form = document.getElementById('replyForm' + answerId);
        form.classList.toggle('hidden');
    }
</script>
@endpush
@endsection