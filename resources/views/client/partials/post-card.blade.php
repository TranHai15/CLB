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
<article class="post-card group overflow-hidden">
    <div class="flex flex-col md:flex-row">
        <a href="{{ route('posts.show', $post->slug) }}" class="md:w-2/5 lg:w-1/3 h-64 md:h-auto block overflow-hidden">
            <img src="{{ $post->image ?? 'https://via.placeholder.com/400x300/1f2937/f59e0b?text=BeeIT+Post' }}"
                alt="{{ $post->title }}"
                loading="lazy"
                class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500 ease-in-out"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300/1f2937/f59e0b?text=No+Image'">
        </a>
        <div class="flex-1 p-6 md:p-8 flex flex-col justify-between">
            <div>
                <div class="mb-3">
                    @if($post->category)
                    <a href="{{ route('category.show', $post->category->slug) }}"
                        class="category-badge inline-block text-xs font-semibold px-3 py-1.5 rounded-full transition-colors duration-200">
                        {{ $post->category->name }}
                    </a>
                    @endif
                </div>

                <h3 class="text-xl lg:text-2xl font-bold mb-3 post-title">
                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                </h3>



                <div class="flex flex-wrap gap-x-3 gap-y-2 mb-5">
                    @foreach($post->tags->take(3) as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}"
                        class="text-xs text-gray-500 hover:text-amber-400 transition-colors duration-200 border border-gray-700 hover:border-amber-500 px-2 py-0.5 rounded-full">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-auto pt-5 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('user.show', $post->creator->slug ) }}" class="block shrink-0">
                            <img src="{{ $post->creator->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($post->creator->name).'&background=374151&color=f3f4f6&font-size=0.45' }}"
                                alt="{{ $post->creator->name }}"
                                loading="lazy"
                                class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-700 group-hover:ring-amber-500 transition-all duration-300">
                        </a>
                        <div>
                            <a href="{{ route('user.show', $post->creator->slug ) }}" class="font-medium text-gray-200 hover:text-amber-400 transition-colors duration-200 text-sm">
                                {{ $post->creator->name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <a href="{{ route('posts.show', $post->slug) }}"
                        class="inline-flex items-center text-amber-400 hover:text-amber-500 text-sm font-medium transition-colors duration-200 group">
                        Đọc thêm
                        <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>