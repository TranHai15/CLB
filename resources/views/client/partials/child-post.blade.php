<style>
    .sidebar-widget {
        background-color: var(--dark-card-bg);
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #374151;
        /* Gray-700 border */
    }

    .sidebar-widget h3 {
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .sidebar-post-item:hover {
        background-color: var(--dark-card-bg-hover);
    }

    .sidebar-post-item img {
        transition: transform 0.3s ease;
    }

    .sidebar-post-item:hover img {
        transform: scale(1.05);
    }
</style>
<a href="{{ route('posts.show', $post->slug) }}"
    class="sidebar-post-item block py-5 hover:bg-gray-700/50 transition-colors duration-200 first:pt-0 last:pb-0 px-2 -mx-2 rounded-md">
    <div class="flex items-center space-x-4">
        <img src="{{ $post->image ?? 'https://via.placeholder.com/150/1f2937/f59e0b?text=BeeIT' }}"
            alt="{{ $post->title }}"
            loading="lazy"
            class="h-16 w-16 rounded-lg object-cover flex-shrink-0">
        <div class="flex-1">
            <h4 class="text-base font-medium text-gray-200 line-clamp-2 hover:text-amber-400 transition-colors">
                {{ $post->title }}
            </h4>
            <p class="text-xs text-gray-500 mt-1.5">
                {{ $post->created_at->translatedFormat('j M, Y') }} <!-- More specific date format -->
            </p>
        </div>
    </div>
</a>