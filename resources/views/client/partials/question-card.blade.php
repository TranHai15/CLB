<style>
    .post-card {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
</style>
<article class="post-card bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6">
        <div class="flex flex-wrap gap-2 mb-4">
            @if($question->category)
            <a href="{{ route('category.show', $question->category->slug) }}"
                class="category-badge inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-100">
                {{ $question->category->name }}
            </a>
            @endif
        </div>

        <h3 class="text-xl post-title font-bold mb-3 hover:text-blue-600 transition-colors">
            <a href="{{ route('questions.show', $question->slug) }}">{{ $question->title }}</a>
        </h3>

        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($question->tags as $tag)
            <a href="{{ route('tag.show', $tag->slug) }}"
                class="text-xs text-gray-500 hover:text-amber-400 transition-colors duration-200 border border-gray-700 hover:border-amber-500 px-2 py-0.5 rounded-full">
                #{{ $tag->name }}
            </a>
            @endforeach
        </div>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center space-x-3">
                <a href="{{ route('user.show', $question->creator->slug ) }}" class="block shrink-0">
                    <img src="{{ $question->creator->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($question->creator->name).'&background=374151&color=f3f4f6&font-size=0.45' }}"
                        alt="{{ $question->creator->name }}"
                        loading="lazy"
                        class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-700 group-hover:ring-amber-500 transition-all duration-300">
                </a>
                <div>
                    <a href="{{ route('user.show', $question->creator->slug ) }}" class="font-medium text-gray-200 hover:text-amber-400 transition-colors duration-200 text-sm">
                        {{ $question->creator->name }}
                    </a>
                    <p class="text-xs text-gray-500">{{ $question->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex gap-2 items-center">
                    <div class="flex items-center text-gray-500">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>{{ $question->answers_count ?? 0 }}</span>
                    </div>
                    <div class="flex items-center text-gray-500">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>{{ $question->views_count ?? 0 }}</span>
                    </div>
                </div>
                <a href="{{ route('questions.show', $question->slug) }}"
                    class=" items-center text-amber-400 hover:text-amber-500 text-sm font-medium transition-colors duration-200 group hidden sm:inline-flex">
                    Xem chi tiết
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>