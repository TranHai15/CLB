@extends('layouts.home')

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-3/4">
            <article class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <!-- Category -->
                <div class="mb-4">
                    <a href="/category/{{ $question['category']['slug'] }}"
                        class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                        {{ $question['category']['name'] }}
                    </a>
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold mb-6">{{ $question['title'] }}</h1>

                <!-- Author Info -->
                <div class="flex items-center mb-8 border-b pb-6">
                    <a href="{{ $question['author']['name'] }}" class="block flex-shrink-0">
                        <img src="{{ $question['author']['avatar'] }}"
                            alt="{{ $question['author']['name'] }}"
                            class="h-14 w-14 rounded-full object-cover mr-4">
                    </a>
                    <div>
                        <a href="{{ $question['author']['name'] }}" class="text-lg font-medium text-gray-900 hover:underline">
                            {{ $question['author']['name'] }}
                        </a>
                        <div class="text-sm text-gray-600 mt-1">{{ $question['author']['bio'] }}</div>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <span>{{ \Carbon\Carbon::parse($question['created_at'])->format('d/m/Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ number_format($question['views']) }} lượt xem</span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="prose max-w-none mb-8">
                    {!! $question['content'] !!}
                </div>
            </article>

            <!-- Answers Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6">Câu trả lời ({{ count($question['answers']) }})</h2>

                <!-- Answer Form -->
                <form class="mb-8">
                    <div class="mb-4">
                        <textarea
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="4"
                            placeholder="Viết câu trả lời của bạn..."></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Gửi câu trả lời
                    </button>
                </form>

                <!-- Answers List -->
                <div class="space-y-6">

                    @foreach($question['answers'] as $answer)
                    <div class="flex gap-4">
                        <img src="{{ $answer['author']['avatar'] }}"
                            alt="{{ $answer['author']['name'] }}"
                            class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-medium">{{ $answer['author']['name'] }}</h4>
                                <span class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($answer['created_at'])->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $answer['content'] }}</p>
                            <div class="flex gap-4 mt-2">
                                <button class="text-sm text-gray-500 hover:text-blue-600">
                                    <i class="far fa-thumbs-up mr-1"></i>
                                    {{ $answer['likes'] }} thích
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                <h3 class="text-lg font-bold mb-4">Câu hỏi mới nhất</h3>
                <div class="space-y-4">

                    @foreach($relatedQuestions as $related)
                    <div>
                        <h4 class="font-medium text-lg mb-2 hover:text-blue-600">
                            <a href="{{ route('questions.show', $related['id']) }}">{{ $related['title'] }}</a>
                        </h4>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>{{ $related['answers_count'] }} câu trả lời</span>
                            <span class="mx-2">•</span>
                            <span>{{ number_format($related['views']) }} lượt xem</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection