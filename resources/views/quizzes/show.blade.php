<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $quiz->title }}
            </h2>
            @if(auth()->id() === $quiz->user_id)
            <a href="{{ route('quizzes.edit', $quiz) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Quiz
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Description</h3>
                        <p class="mt-1 text-gray-600">{{ $quiz->description }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Quiz Details</h3>
                        <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $quiz->quizType->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $quiz->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Visibility</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $quiz->is_public ? 'Public' : 'Private' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Questions</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $quiz->questions->count() }}</dd>
                            </div>
                        </dl>
                    </div>

                    @if($quiz->questions->isNotEmpty())
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Questions</h3>
                            <div class="space-y-6">
                                @foreach($quiz->questions as $index => $question)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Question {{ $index + 1 }}</h4>
                                                <p class="mt-1">{{ $question->question_text }}</p>
                                                
                                                @if($question->question_type === 'multiple_choice')
                                                    <div class="mt-3 space-y-2">
                                                        @foreach($question->answers as $answer)
                                                            <div class="flex items-center">
                                                                <span class="ml-2 text-sm text-gray-700">{{ $answer->answer_text }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ ucfirst($question->question_type) }} • {{ $question->points }} points
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No questions have been added to this quiz yet.</p>
                        </div>
                    @endif

                    @if(auth()->id() !== $quiz->user_id)
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('quiz-attempts.create', $quiz) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">
                                Take Quiz
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 