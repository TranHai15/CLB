@extends('layouts.home')
@section('content')
@include('client.partials.banner')

<!-- Main Content -->
<div class=" py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Main Content Area -->
            <main class="lg:col-span-8 space-y-12">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl sm:text-4xl font-bold section-title">Bài viết mới nhất</h2>
                    <a href="{{ route('blog') }}" class="text-amber-400 hover:text-amber-500 font-medium flex items-center group transition-colors">
                        <span class="hidden sm:inline"> Xem tất cả</span>
                        <span class="block sm:hidden"> Thêm</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid gap-8 md:gap-10">
                    @forelse($posts as $post)
                    @include('client.partials.post-card', ['post' => $post])
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-300">Không có bài viết nào</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Hiện tại chưa có bài viết nào được đăng. Quay lại sau nhé!
                        </p>
                    </div>
                    @endforelse
                </div>

                @if ($posts->hasPages())
                <div class="mt-12 pagination">
                    {{ $posts->links() }}
                </div>
                @endif
            </main>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-10 hidden sm:block">
                <div class="sidebar-widget">
                    <h3 class="text-xl">Bài viết nổi bật</h3>
                    <div class="divide-y divide-gray-700">
                        @forelse($topPosts as $post)
                        @include('client.partials.child-post',['post'=>$post])
                        @empty
                        <p class="text-gray-500 py-4">Chưa có bài viết nổi bật.</p>
                        @endforelse
                    </div>
                </div>

                <!-- You can add more widgets here, e.g., Categories, Tags -->
                <div class="sidebar-widget">
                    <h3 class="text-xl">Tags Phổ Biến</h3>
                    <div class="flex flex-wrap gap-2">
                        {{-- Assuming you have a $tags variable passed to the view --}}
                        @php
                        $sampleTags = ['Laravel', 'PHP', 'JavaScript', 'VueJS', 'React', 'TailwindCSS', 'API', 'Tutorial'];
                        @endphp
                        @foreach($sampleTags as $tag)
                        <a href="#" class="category-badge text-xs font-semibold px-3 py-1.5 rounded-full">
                            {{ $tag }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection