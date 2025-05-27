@extends('layouts.home')
<style>
    .post-title {
        color: white !important;
    }

    .post-input {
        background: #1f2937 !important;
    }

    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        /* 12px */
        border: 1px solid transparent;
    }
</style>
@section('content')
<div class="container max-w-7xl  mx-auto px-4 py-8">
    <!-- Profile Header -->
    <div class=" rounded-lg shadow-sm overflow-hidden mb-8 post-card">
        <!-- Cover Image -->
        <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 relative">
            @if($user->cover_image)
            <img src="{{ $user->cover_image }}" alt="Cover" class="w-full h-full object-cover">
            @endif
            <!-- Edit Profile Button (if viewing own profile) -->
            @if(auth()->check() && auth()->id() === $user->id)
            <a href="{{ route('profile.edit') }}"
                class="absolute bottom-4 right-4 bg-white text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                <i class="fas fa-edit mr-2"></i>Chỉnh sửa trang cá nhân
            </a>
            @endif
        </div>

        <!-- Profile Info -->
        <div class="px-6 py-8 post-card ">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Avatar -->
                <div class="relative -mt-20 md:-mt-24">
                    <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}"
                        alt="{{ $user->name }}"
                        class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-lg">
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold post-title ">{{ $user->name }}</h1>
                            @if($user->title)
                            <p class="text-gray-600 mt-1">{{ $user->title }}</p>
                            @endif
                        </div>
                        <!-- Follow Button -->
                        @if(auth()->check())
                        @if(auth()->id() !== $user->id)
                        @if(auth()->user()->follows()->where('target_user_id', $user->id)->exists())
                        <form action="{{ route('user.unfollow', $user->slug) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class="fas fa-user-minus mr-2"></i>Hủy theo dõi
                            </button>
                        </form>
                        @else
                        <form action="{{ route('user.follow', $user->slug) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Theo dõi
                            </button>
                        </form>
                        @endif
                        @endif
                        @else
                        <form action="{{ route('user.follow', $user->slug ?? null) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Theo dõi
                            </button>
                        </form>
                        @endif
                        <!-- Stats -->
                        <div class="flex gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold post-title ">{{ $user->questions_count }}</div>
                                <div class="text-sm text-gray-500">Câu hỏi</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold post-title ">{{ $user->following_count }}</div>
                                <div class="text-sm text-gray-500">Đang theo dõi</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold post-title ">{{ $user->followers_count }}</div>
                                <div class="text-sm text-gray-500">Người theo dõi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($user->bio)
                    <p class="text-gray-600 mt-4">{{ $user->bio }}</p>
                    @endif

                    <!-- Social Links -->
                    @if($user->social_links)
                    <div class="flex gap-4 mt-4">
                        @if($user->social_links['github'] ?? false)
                        <a href="{{ $user->social_links['github'] }}" target="_blank" class="text-gray-600 hover:post-title ">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                        @endif
                        @if($user->social_links['twitter'] ?? false)
                        <a href="{{ $user->social_links['twitter'] }}" target="_blank" class="text-gray-600 hover:post-title ">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        @endif
                        @if($user->social_links['linkedin'] ?? false)
                        <a href="{{ $user->social_links['linkedin'] }}" target="_blank" class="text-gray-600 hover:post-title ">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Following and Followers -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Following -->
        <div class="post-card rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold post-title  mb-4">Đang theo dõi</h2>
            <div class="space-y-4">
                @forelse($following as $followedUser)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $followedUser->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($followedUser->name).'&background=random' }}"
                            alt="{{ $followedUser->name }}"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <a href="{{ route('user.show', $followedUser->slug) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $followedUser->name }}
                            </a>
                            @if($followedUser->title)
                            <p class="text-sm text-gray-500">{{ $followedUser->title }}</p>
                            @endif
                        </div>
                    </div>
                    @if(auth()->check() && auth()->id() !== $followedUser->id)
                    <button class="text-sm text-gray-500 hover:text-gray-700">
                        <i class="fas fa-user-minus"></i>
                    </button>
                    @endif
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Chưa theo dõi ai</p>
                @endforelse
            </div>
        </div>

        <!-- Followers -->
        <div class="post-card rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold post-title  mb-4">Người theo dõi</h2>
            <div class="space-y-4">
                @forelse($followers as $follower)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $follower->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($follower->name).'&background=random' }}"
                            alt="{{ $follower->name }}"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <a href="{{ route('user.show', $follower->slug) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $follower->name }}
                            </a>
                            @if($follower->title)
                            <p class="text-sm text-gray-500">{{ $follower->title }}</p>
                            @endif
                        </div>
                    </div>
                    @if(auth()->check() && auth()->id() !== $follower->id)
                    <button class="text-sm text-gray-500 hover:text-gray-700">
                        <i class="fas fa-user-plus"></i>
                    </button>
                    @endif
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Chưa có người theo dõi</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Questions List -->
    <div class="post-card rounded-lg shadow-sm mb-8">
        <div class="p-6">
            <h2 class="text-xl font-semibold post-title  mb-6">Danh sách câu hỏi</h2>
            <div class="space-y-6">
                @forelse($questions as $question)
                <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex flex-col">
                        <!-- Title -->
                        <h2 class="text-xl font-semibold post-title  mb-3">
                            <a href="{{ route('questions.show', $question->slug) }}" class="hover:text-blue-600 transition-colors">
                                {{ $question->title }}
                            </a>
                        </h2>

                        <!-- Content Preview -->
                        @if($question->content)
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($question->content), 200) }}

                        </p>
                        @endif

                        <!-- Meta Information -->
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            <!-- Creator -->
                            <div class="flex items-center">
                                <img src="{{ $question->creator->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($question->creator->name).'&background=random' }}"
                                    alt="{{ $question->creator->name }}"
                                    class="w-6 h-6 rounded-full mr-2">
                                <a href="{{ route('user.show', $question->creator->slug) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $question->creator->name }}
                                </a>
                            </div>

                            <!-- Category -->
                            @if($question->category)
                            <span class="inline-flex items-center bg-gray-100 px-3 py-1 rounded-full">
                                <i class="fas fa-folder text-gray-500 mr-2"></i>
                                <a href="{{ route('category.show', $question->category->slug) }}"
                                    class="hover:text-blue-600 transition-colors">
                                    {{ $question->category->name }}
                                </a>
                            </span>
                            @endif

                            <!-- Tags -->
                            @if($question->tags->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($question->tags as $tag)
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
                                <span class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-eye text-gray-500 mr-2"></i>
                                    {{ number_format($question->views) }}
                                </span>
                                <span class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-comments text-blue-500 mr-2"></i>
                                    {{ number_format($question->comments_count) }}
                                </span>
                                <span class="inline-flex items-center bg-gray-50 px-3 py-1 rounded-full">
                                    <i class="fas fa-calendar text-gray-500 mr-2"></i>
                                    {{ $question->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-gray-500">
                        <i class="fas fa-question-circle mb-4 text-4xl"></i>
                        <p class="text-lg">Chưa có câu hỏi nào</p>
                    </div>
                </div>
                @endforelse

                <!-- Pagination -->
                @if($questions->hasPages())
                <div class="mt-8">
                    {{ $questions->links() }}
                </div>
                @endif
            </div>
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
</style>
@endpush