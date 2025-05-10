@extends('layouts.home')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <main class="lg:col-span-3 space-y-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Câu hỏi mới nhất</h2>
                    <a href="{{ route('questions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-700 hover:bg-blue-800 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Đặt câu hỏi
                    </a>
                </div>

                <div class="grid gap-4">
                    @foreach($questions as $question)
                    @include('client.partials.question-card', ['question' => $question])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $questions->links() }}
                </div>
            </main>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-6">
                <!-- Categories Dropdown -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full px-4 py-3 flex items-center justify-between text-left hover:bg-gray-50/80 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">Danh mục</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="border-t border-gray-200">
                        <div class="py-2">
                            <a href="{{ route('questions.index') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50/80 hover:text-blue-800 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span>Tất cả danh mục</span>
                                    <span class="text-sm text-gray-600">{{ $questions->total() }}</span>
                                </div>
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('category.show', $category->slug) }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50/80 hover:text-blue-800 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-sm text-gray-600">{{ $category->questions_count }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Tags Dropdown -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full px-4 py-3 flex items-center justify-between text-left hover:bg-gray-50/80 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">Tags phổ biến</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="border-t border-gray-200">
                        <div class="p-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                <a href="{{ route('tag.show', $tag->slug) }}"
                                    class="inline-block px-3 py-1 rounded-full text-sm bg-gray-100/80 text-gray-700 hover:bg-blue-100/80 hover:text-blue-800 transition-colors">
                                    #{{ $tag->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection