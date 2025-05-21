<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $quiz->title }}
            </h2>
            <div class="text-sm text-gray-500">
                Time Started: {{ $attempt->started_at->format('g:i A') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <p class="text-gray-600">{{ $quiz->description }}</p>
                    </div>

                    <form id="quizForm" method="POST" action="{{ route('quiz-attempts.submit', $attempt) }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        @foreach($quiz->questions()->orderBy('order')->get() as $index => $question)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Question {{ $index + 1 }}: {{ $question->question_text }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">Points: {{ $question->points }}</p>
                            </div>

                            @if($question->question_type === 'multiple_choice')
                                <div class="space-y-3">
                                    @foreach($question->answers->shuffle() as $answer)
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $answer->id }}"
                                               class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               required>
                                        <span class="ml-3 text-gray-700">{{ $answer->answer_text }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            @else
                                <div>
                                    <textarea name="answers[{{ $question->id }}]"
                                              rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                              placeholder="Enter your answer here..."
                                              required></textarea>
                                </div>
                            @endif
                        </div>
                        @endforeach

                        <div class="flex justify-end space-x-3">
                            <x-secondary-button type="button" onclick="if(confirm('Are you sure you want to quit? Your progress will be lost.')) window.location.href='{{ route('quizzes.index') }}'">
                                Quit Quiz
                            </x-secondary-button>
                            <x-primary-button type="submit">
                                Submit Answers
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get all form data
            const formData = new FormData(this);
            
            // Submit using fetch
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else if (!response.ok) {
                    throw new Error('Failed to submit quiz');
                }
            })
            .catch(error => {
                alert('Failed to submit quiz. Please try again.');
            });
        });
    </script>
    @endpush
</x-app-layout> 