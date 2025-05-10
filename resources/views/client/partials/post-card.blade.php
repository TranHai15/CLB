<article class="post-card bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="flex flex-col md:flex-row">
        <a href="{{ route('posts.show', $post->slug) }}" class="md:w-1/3 h-64 md:h-auto overflow-hidden">
            <img src="{{ $post->image ?? '' }}"
                alt="{{ $post->title }}"
                loading="lazy"
                class="h-full w-full object-cover transform hover:scale-105 transition duration-500"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image'">
        </a>
        <div class="flex-1 p-6">
            <div class="flex flex-wrap gap-2 mb-4">
                @if($post->category)
                <a href="{{ route('category.show', $post->category->slug) }}"
                    class="category-badge inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-100">
                    {{ $post->category->name }}
                </a>
                @endif
            </div>

            <h3 class="text-xl font-bold mb-3 hover:text-blue-600 transition-colors">
                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
            </h3>

            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($post->tags as $tag)
                <a href="{{ route('tag.show', $tag->slug) }}"
                    class="text-sm text-gray-600 hover:text-blue-600 transition-colors">
                    #{{ $tag->name }}
                </a>
                @endforeach
            </div>

            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.show', $post->creator->slug ) }}" class="group">
                        <img src="{{ $post->creator->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($post->creator->name) }}"
                            alt="{{ $post->creator->name }}"
                            loading="lazy"
                            class="h-10 w-10 rounded-full object-cover ring-2 ring-transparent group-hover:ring-blue-500 transition-all duration-200">
                    </a>
                    <div>
                        <p class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                            {{ $post->creator->name }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <a href="{{ route('posts.show', $post->slug) }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    Đọc thêm
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>