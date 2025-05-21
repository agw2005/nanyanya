<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ request('filter') === 'created' ? 'My Created Quizzes' : 'Available Quizzes' }}
            </h2>
            @if(auth()->user()->is_quiz_maker)
            <a href="{{ route('quizzes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Create New Quiz
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($quizzes->isEmpty())
                        <p class="text-center text-gray-500">No quizzes available.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($quizzes as $quiz)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-sm font-medium {{ $quiz->is_public ? 'text-green-600' : 'text-orange-600' }}">
                                            {{ $quiz->is_public ? 'Public' : 'Private' }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $quiz->quizType->name }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $quiz->title }}</h3>
                                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $quiz->description }}</p>
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span>By {{ $quiz->user->name }}</span>
                                        <span>{{ $quiz->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-500">
                                                {{ $quiz->attempts_count ?? 0 }} attempts
                                            </span>
                                            <span class="text-sm text-gray-500">•</span>
                                            <span class="text-sm text-gray-500">
                                                {{ $quiz->comments_count ?? 0 }} comments
                                            </span>
                                        </div>
                                        @if($quiz->user_id === auth()->id())
                                            <a href="{{ route('quizzes.edit', $quiz) }}" class="text-blue-600 hover:text-blue-800">
                                                Edit
                                            </a>
                                        @else
                                            <a href="{{ route('quiz-attempts.start', $quiz) }}" class="text-green-600 hover:text-green-800">
                                                Take Quiz
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $quizzes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 