<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Results: {{ $quiz->title }}
            </h2>
            <div class="text-sm text-gray-500">
                Completed: {{ $attempt->completed_at->format('M d, Y g:i A') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Score Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Your Score</h3>
                            <p class="text-sm text-gray-500">Time taken: {{ $attempt->started_at->diffInMinutes($attempt->completed_at) }} minutes</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-indigo-600">{{ $attempt->score }} points</p>
                            <p class="text-sm text-gray-500">
                                out of {{ $quiz->questions->sum('points') }} possible points
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Detailed Results</h3>

                    <div class="space-y-6">
                        @foreach($quiz->questions()->orderBy('order')->get() as $index => $question)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="mb-4">
                                <h4 class="text-lg font-medium text-gray-900">
                                    Question {{ $index + 1 }}: {{ $question->question_text }}
                                </h4>
                                <p class="text-sm text-gray-500">Points: {{ $question->points }}</p>
                            </div>

                            @if($question->question_type === 'multiple_choice')
                                <div class="space-y-3">
                                    @foreach($question->answers as $answer)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($answer->is_correct)
                                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif($answer->id === $attempt->results[$question->id]['user_answer'])
                                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-700">{{ $answer->answer_text }}</p>
                                            @if($answer->is_correct && $answer->explanation)
                                                <p class="text-sm text-gray-500 mt-1">{{ $answer->explanation }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div>
                                    <p class="font-medium text-gray-700">Your Answer:</p>
                                    <p class="mt-2 text-gray-600">{{ $attempt->results[$question->id]['user_answer'] }}</p>
                                    <p class="mt-2 text-sm text-orange-600">This answer requires manual review.</p>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('quiz-attempts.history') }}" class="text-indigo-600 hover:text-indigo-800">
                            View Attempt History
                        </a>
                        <a href="{{ route('quizzes.index') }}" class="text-indigo-600 hover:text-indigo-800">
                            Back to Quizzes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Comments</h3>

                    <!-- Comment Form -->
                    <form action="{{ route('comments.store', $quiz) }}" method="POST" class="mb-6">
                        @csrf
                        <div>
                            <textarea name="content" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Leave a comment..." required></textarea>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <x-primary-button>
                                Post Comment
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Comments List -->
                    <div class="space-y-6">
                        @foreach($quiz->comments()->with('user')->latest()->get() as $comment)
                        <div class="flex space-x-4" data-comment-id="{{ $comment->id }}">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="comment-content mt-1 text-gray-700">{{ $comment->content }}</div>
                                @if($comment->user_id === auth()->id())
                                <div class="mt-2 flex space-x-2">
                                    <button type="button" onclick="editComment({{ $comment->id }}, '{{ $comment->content }}')" class="text-sm text-blue-600 hover:text-blue-800">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('comments.destroy', [$quiz, $comment]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this comment?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editComment(commentId, content) {
            const commentDiv = document.querySelector(`[data-comment-id="${commentId}"]`);
            const contentDiv = commentDiv.querySelector('.comment-content');
            const currentContent = content;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Create edit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/quizzes/{{ $quiz->id }}/comments/' + commentId;
            
            const textarea = document.createElement('textarea');
            textarea.name = 'content';
            textarea.className = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
            textarea.required = true;
            textarea.value = currentContent;

            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'mt-2 flex justify-end space-x-2';

            const cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.className = 'text-sm text-gray-600 hover:text-gray-800';
            cancelButton.textContent = 'Cancel';
            cancelButton.onclick = () => cancelEdit(commentId, currentContent);

            const saveButton = document.createElement('button');
            saveButton.type = 'submit';
            saveButton.className = 'text-sm text-blue-600 hover:text-blue-800';
            saveButton.textContent = 'Save';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';

            buttonDiv.appendChild(cancelButton);
            buttonDiv.appendChild(saveButton);

            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            form.appendChild(textarea);
            form.appendChild(buttonDiv);

            contentDiv.replaceWith(form);
        }

        function cancelEdit(commentId, content) {
            const commentDiv = document.querySelector(`[data-comment-id="${commentId}"]`);
            const form = commentDiv.querySelector('form');
            
            const contentDiv = document.createElement('div');
            contentDiv.className = 'comment-content mt-1 text-gray-700';
            contentDiv.textContent = content;
            
            form.replaceWith(contentDiv);
        }
    </script>
    @endpush
</x-app-layout> 