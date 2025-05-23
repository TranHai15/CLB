const ThemeSwitcher = {
    themeToggleButton: null,
    currentTheme: localStorage.getItem("theme") || "light",

    init() {
        this.themeToggleButton = document.getElementById("theme-toggle");
        if (!this.themeToggleButton) {
            // console.warn('Theme toggle button not found.');
            return;
        }

        this.applyTheme(this.currentTheme);
        this.updateButtonIcon(this.currentTheme);

        this.themeToggleButton.addEventListener("click", () => {
            this.toggleTheme();
        });

        // Optional: Listen for system theme changes
        // window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        //     if (localStorage.getItem('theme') === null) { // Only if user hasn't set a preference
        //         const newColorScheme = e.matches ? 'dark' : 'light';
        //         this.applyTheme(newColorScheme);
        //         this.updateButtonIcon(newColorScheme);
        //     }
        // });
    },

    toggleTheme() {
        const newTheme = this.currentTheme === "light" ? "dark" : "light";
        this.applyTheme(newTheme);
        this.updateButtonIcon(newTheme);
    },

    applyTheme(theme) {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
        this.currentTheme = theme;
        localStorage.setItem("theme", theme);
    },

    updateButtonIcon(theme) {
        if (!this.themeToggleButton) return;

        const lightIcon = this.themeToggleButton.querySelector(
            ".theme-toggle-light-icon"
        );
        const darkIcon = this.themeToggleButton.querySelector(
            ".theme-toggle-dark-icon"
        );
        if (lightIcon && darkIcon) {
            if (theme === "dark") {
                lightIcon.classList.remove("hidden");
                darkIcon.classList.add("hidden");
            } else {
                lightIcon.classList.add("hidden");
                darkIcon.classList.remove("hidden");
            }
        } else {
            // Fallback if specific icons aren't found, maybe change button text
            // this.themeToggleButton.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
        }
    },
};

// Apply theme immediately on script load to prevent FOUC (Flash of Unstyled Content)
const savedTheme = localStorage.getItem("theme");
const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

if (savedTheme === "dark" || (!savedTheme && prefersDark)) {
    document.documentElement.classList.add("dark");
} else {
    document.documentElement.classList.remove("dark");
}

// Initialize after DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    ThemeSwitcher.init();
});

// Export if you're using modules (e.g., with Vite)
// export default ThemeSwitcher;
{{-- resources/views/client/post/post.blade.php --}}
@extends('layouts.home') {{-- Or your main client layout --}}

@section('title', $post->title)

@push('styles')
<style>
    /* Styles specific to post page, if any, can go here or in app.css */
    .prose { /* Base prose styling for article content */
        color: var(--color-text-base);
    }
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: var(--color-text-base);
        font-weight: 600;
    }
    .prose a {
        color: var(--color-primary);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .prose a:hover {
        color: var(--color-primary-hover);
        text-decoration: underline;
    }
    .prose strong {
        color: var(--color-text-base);
        font-weight: 600;
    }
    .prose blockquote {
        border-left-color: var(--color-primary);
        color: var(--color-text-muted);
    }
    .prose code {
        background-color: var(--color-bg-muted);
        color: var(--color-text-base);
        padding: 0.2em 0.4em;
        margin: 0;
        font-size: 85%;
        border-radius: 3px;
    }
    .prose pre {
        background-color: var(--color-bg-muted);
        color: var(--color-text-base);
        border-radius: 0.5rem;
        padding: 1rem;
        overflow-x: auto;
    }
    .prose pre code {
        background-color: transparent;
        padding: 0;
        margin: 0;
        font-size: inherit;
        border-radius: 0;
    }
    .prose img {
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    }
    html.dark .prose img {
        box-shadow: 0 4px 6px -1px rgba(255,255,255,0.05), 0 2px 4px -1px rgba(255,255,255,0.03);
    }

    /* Comment section styling */
    .comment {
        background-color: var(--color-bg-surface);
        border: 1px solid var(--color-border-base);
        transition: transform 0.2s ease-out, box-shadow 0.2s ease-out;
    }
    .comment:hover {
        /* transform: translateY(-2px); */
        /* box-shadow: 0 10px 15px -3px rgba(0,0,0,0.07), 0 4px 6px -2px rgba(0,0,0,0.03); */
        /* html.dark & { box-shadow: 0 10px 15px -3px rgba(255,255,255,0.03), 0 4px 6px -2px rgba(255,255,255,0.01); } */
    }
    .comment-form textarea {
        background-color: var(--color-bg-muted);
        color: var(--color-text-base);
        border-color: var(--color-border-muted);
    }
    .comment-form textarea:focus {
        border-color: var(--color-primary);
        --tw-ring-color: var(--color-primary);
    }
</style>
@endpush

@section('content')
<div class="py-12 md:py-16 bg-[var(--color-bg-base)] transition-colors duration-300">
    <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <article class="bg-[var(--color-bg-surface)] shadow-xl rounded-xl overflow-hidden transition-colors duration-300">
            @if($post->image)
            <div class="w-full h-64 md:h-96 overflow-hidden">
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="p-6 md:p-10">
                <!-- Post Meta -->
                <div class="mb-6 md:mb-8 text-center">
                    @if($post->category)
                    <a href="{{ route('category.show', $post->category->slug) }}"
                       class="inline-block bg-[var(--color-primary)] text-[var(--color-primary-content)] px-4 py-1.5 rounded-full text-xs sm:text-sm font-semibold uppercase tracking-wider hover:bg-[var(--color-primary-hover)] transition-colors duration-200 mb-3">
                        {{ $post->category->name }}
                    </a>
                    @endif
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[var(--color-text-base)] mb-4 leading-tight">
                        {{ $post->title }}
                    </h1>
                    <div class="flex items-center justify-center space-x-4 text-[var(--color-text-muted)] text-sm">
                        <div class="flex items-center">
                            <img src="{{ $post->creator->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($post->creator->name).'&background=random' }}"
                                 alt="{{ $post->creator->name }}" class="w-8 h-8 rounded-full mr-2 object-cover">
                            <a href="{{ route('user.show', $post->creator->slug) }}" class="hover:text-[var(--color-primary)] transition-colors">
                                {{ $post->creator->name }}
                            </a>
                        </div>
                        <span>&bull;</span>
                        <span>{{ $post->created_at->translatedFormat('j M, Y') }}</span>
                        <span>&bull;</span>
                        <span>{{ $post->views }} lượt xem</span>
                        {{-- Optional: Reading time --}}
                        {{-- <span>&bull;</span> --}}
                        {{-- <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} phút đọc</span> --}}
                    </div>
                </div>

                <!-- Post Content -->
                <div class="prose prose-lg lg:prose-xl max-w-none mx-auto">
                    {!! $post->content !!} {{-- Make sure content is sanitized if it comes from users --}}
                </div>

                <!-- Tags -->
                @if($post->tags->isNotEmpty())
                <div class="mt-8 md:mt-12 pt-6 border-t border-[var(--color-border-base)]">
                    <h3 class="text-sm font-semibold text-[var(--color-text-muted)] uppercase tracking-wider mb-3">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}"
                           class="px-3 py-1 bg-[var(--color-bg-muted)] text-[var(--color-text-muted)] hover:bg-[var(--color-primary)] hover:text-[var(--color-primary-content)] rounded-full text-xs font-medium transition-all duration-200 transform hover:scale-105">
                            #{{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Author Bio (Optional) -->
                <div class="mt-8 md:mt-12 pt-6 border-t border-[var(--color-border-base)]">
                    <div class="flex items-start space-x-4 p-4 bg-[var(--color-bg-muted)] rounded-lg">
                        <img src="{{ $post->creator->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($post->creator->name).'&background=random' }}"
                             alt="{{ $post->creator->name }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                        <div>
                            <h4 class="text-lg font-semibold text-[var(--color-text-base)] mb-1">
                                <a href="{{ route('user.show', $post->creator->slug) }}" class="hover:text-[var(--color-primary)] transition-colors">
                                    {{ $post->creator->name }}
                                </a>
                            </h4>
                            <p class="text-sm text-[var(--color-text-muted)] line-clamp-3">
                                {{ $post->creator->bio ?? 'Không có thông tin giới thiệu.' }}
                            </p>
                            {{-- Add follow button if implemented --}}
                            @auth
                                @if(Auth::id() !== $post->creator->id)
                                    {{-- Example: Check if already following --}}
                                    @php $isFollowing = Auth::user()->follows()->where('target_user_id', $post->creator->id)->exists(); @endphp
                                    <form action="{{ $isFollowing ? route('user.unfollow', $post->creator->slug) : route('user.follow', $post->creator->slug) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs px-3 py-1.5 rounded-md font-medium transition-colors duration-200
                                                       {{ $isFollowing
                                                           ? 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-500'
                                                           : 'bg-[var(--color-primary)] text-[var(--color-primary-content)] hover:bg-[var(--color-primary-hover)]' }}">
                                            {{ $isFollowing ? 'Đang theo dõi' : 'Theo dõi' }}
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Like Button -->
                @auth
                <div class="mt-8 md:mt-12 pt-6 border-t border-[var(--color-border-base)] text-center">
                    <form action="{{ $post->is_liked ? route('posts.unlike', $post->id) : route('posts.like', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 rounded-lg font-semibold text-base transition-all duration-200 transform hover:scale-105
                                       {{ $post->is_liked
                                           ? 'bg-red-100 dark:bg-red-800/30 text-red-600 dark:text-red-400 border border-red-500 dark:border-red-600 hover:bg-red-200 dark:hover:bg-red-700/50'
                                           : 'bg-[var(--color-primary)] text-[var(--color-primary-content)] hover:bg-[var(--color-primary-hover)]' }}">
                            <svg class="w-5 h-5 mr-2 {{ $post->is_liked ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            {{ $post->is_liked ? 'Đã thích' : 'Thích bài viết' }}
                            ({{-- You'd need a likes_count attribute on the post model --}}
                            {{-- $post->likes_count ?? 0 --}} )
                        </button>
                    </form>
                </div>
                @endauth

            </div>
        </article>

        <!-- Comments Section -->
        <section id="comments" class="mt-12 md:mt-16">
            <h2 class="text-2xl md:text-3xl font-bold text-[var(--color-text-base)] mb-6 md:mb-8">
                Bình luận ({{ $post->comments->count() }})
            </h2>

            @auth
module.exports = {
  // ...
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
module.exports = {
  // ...
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
<div class="prose prose-lg lg:prose-xl dark:prose-invert max-w-none mx-auto">
    {!! $post->content !!}
</div>
