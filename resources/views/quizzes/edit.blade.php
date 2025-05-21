<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Quiz') }}: {{ $quiz->title }}
            </h2>
            <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" class="inline">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit" onclick="return confirm('Are you sure you want to delete this quiz?')">
                    {{ __('Delete Quiz') }}
                </x-danger-button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Quiz Details Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">{{ __('Quiz Details') }}</h3>
                    <form method="POST" action="{{ route('quizzes.update', $quiz) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="title" :value="__('Quiz Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $quiz->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $quiz->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="quiz_type_id" :value="__('Quiz Type')" />
                            <select id="quiz_type_id" name="quiz_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach($quizTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('quiz_type_id', $quiz->quiz_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('quiz_type_id')" class="mt-2" />
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_public" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_public', $quiz->is_public) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Make this quiz public') }}</span>
                            </label>
                        </div>

                        <div id="password-section" class="{{ old('is_public', $quiz->is_public) ? 'hidden' : '' }}">
                            <x-input-label for="password" :value="__('New Password (leave blank to keep current)')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Update Quiz Details') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ __('Questions') }}</h3>
                        <button type="button" onclick="showAddQuestionModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                            Add Question
                        </button>
                    </div>

                    <div id="questions-list" class="space-y-4">
                        @foreach($quiz->questions()->orderBy('order')->get() as $question)
                        <div class="bg-gray-50 p-4 rounded-lg question-item" data-question-id="{{ $question->id }}">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <h4 class="font-medium">{{ $question->question_text }}</h4>
                                    <p class="text-sm text-gray-500">
                                        Type: {{ ucfirst($question->question_type) }} • Points: {{ $question->points }}
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="editQuestion({{ json_encode($question->id) }})" class="text-blue-600 hover:text-blue-800">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('questions.destroy', [$quiz, $question]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this question?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if($question->question_type === 'multiple_choice')
                            <div class="ml-4 mt-2">
                                <p class="text-sm font-medium text-gray-700">Answers:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600">
                                    @foreach($question->answers as $answer)
                                    <li class="{{ $answer->is_correct ? 'text-green-600' : '' }}">
                                        {{ $answer->answer_text }}
                                        @if($answer->is_correct)
                                            <span class="text-green-600">(Correct)</span>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Modal -->
    <div id="questionModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4" id="modalTitle">Add Question</h3>
                    <form id="questionForm" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="question_text" :value="__('Question Text')" />
                            <textarea id="question_text" name="question_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        </div>

                        <div>
                            <x-input-label for="question_type" :value="__('Question Type')" />
                            <select id="question_type" name="question_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="toggleAnswersSection()">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="text">Text Answer</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="points" :value="__('Points')" />
                            <x-text-input type="number" id="points" name="points" class="mt-1 block w-full" value="1" min="1" required />
                        </div>

                        <div id="answersSection">
                            <div class="flex justify-between items-center mb-2">
                                <x-input-label :value="__('Answers')" />
                                <button type="button" onclick="addAnswerField()" class="text-sm text-blue-600 hover:text-blue-800">
                                    Add Answer
                                </button>
                            </div>
                            <div id="answerFields" class="space-y-2">
                                <!-- Answer fields will be added here -->
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <x-secondary-button type="button" onclick="hideQuestionModal()">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button type="submit">
                                Save Question
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Make sure the script runs after DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            let currentQuestionId = null;

            // Initialize the answers section visibility
            toggleAnswersSection();

            // Add event listener to the form
            document.getElementById('questionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const questionType = document.getElementById('question_type').value;
                
                if (questionType === 'multiple_choice') {
                    const answers = Array.from(document.querySelectorAll('input[name="answers[][answer_text]"]')).map(input => input.value);
                    const correctAnswer = document.querySelector('input[name="correct_answer"]:checked');
                    
                    if (answers.length < 2) {
                        alert('Please add at least 2 answers for multiple choice questions.');
                        return;
                    }
                    
                    if (!correctAnswer) {
                        alert('Please select a correct answer.');
                        return;
                    }

                    // Convert radio buttons to boolean is_correct values
                    const correctIndex = Array.from(document.querySelectorAll('input[name="correct_answer"]')).findIndex(radio => radio.checked);
                    const answerFields = document.querySelectorAll('input[name="answers[][answer_text]"]');

                    // Remove existing answer data
                    for (const pair of formData.entries()) {
                        if (pair[0].startsWith('answers[')) {
                            formData.delete(pair[0]);
                        }
                    }

                    // Add answers with correct boolean values
                    answerFields.forEach((field, index) => {
                        formData.append(`answers[${index}][answer_text]`, field.value);
                        formData.append(`answers[${index}][is_correct]`, index === correctIndex ? '1' : '0');
                    });
                }

                // Get the CSRF token from the meta tag
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Submit the form with fetch
                fetch(this.action, {
                    method: currentQuestionId ? 'POST' : 'POST', // Always use POST, let Laravel handle the method override
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to save question');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    window.location.reload();
                })
                .catch(error => {
                    alert(error.message || 'Failed to save question. Please try again.');
                });
            });
        });

        function showAddQuestionModal() {
            currentQuestionId = null;
            document.getElementById('modalTitle').textContent = 'Add Question';
            document.getElementById('questionForm').reset();
            document.getElementById('questionForm').action = "{{ route('questions.store', $quiz) }}";
            document.getElementById('answerFields').innerHTML = '';
            addAnswerField();
            addAnswerField();
            document.getElementById('questionModal').classList.remove('hidden');
            toggleAnswersSection();
        }

        function editQuestion(questionId) {
            currentQuestionId = questionId;
            fetch(`/quizzes/{{ $quiz->id }}/questions/${questionId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Question';
                    document.getElementById('question_text').value = data.question_text;
                    document.getElementById('question_type').value = data.question_type;
                    document.getElementById('points').value = data.points;
                    
                    document.getElementById('questionForm').action = `/quizzes/{{ $quiz->id }}/questions/${questionId}`;
                    const form = document.getElementById('questionForm');
                    if (!form.querySelector('input[name="_method"]')) {
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PUT';
                        form.appendChild(methodField);
                    }

                    document.getElementById('answerFields').innerHTML = '';
                    if (data.question_type === 'multiple_choice' && data.answers) {
                        data.answers.forEach(answer => {
                            addAnswerField(answer.answer_text, answer.is_correct);
                        });
                    }
                    
                    document.getElementById('questionModal').classList.remove('hidden');
                    toggleAnswersSection();
                });
        }

        function hideQuestionModal() {
            document.getElementById('questionModal').classList.add('hidden');
            document.getElementById('questionForm').reset();
        }

        function addAnswerField(answerText = '', isCorrect = false) {
            const container = document.createElement('div');
            container.className = 'flex space-x-2';
            container.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="answers[][answer_text]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Answer text" value="${answerText}" required>
                </div>
                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="radio" name="correct_answer" value="${Date.now()}" class="text-indigo-600 border-gray-300 focus:ring-indigo-500" ${isCorrect ? 'checked' : ''}>
                        <span class="ml-2 text-sm text-gray-600">Correct</span>
                    </label>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    Remove
                </button>
            `;
            document.getElementById('answerFields').appendChild(container);
        }

        function toggleAnswersSection() {
            const questionType = document.getElementById('question_type').value;
            const answersSection = document.getElementById('answersSection');
            if (answersSection) {
                answersSection.style.display = questionType === 'multiple_choice' ? 'block' : 'none';
            }
        }

        // Initialize Sortable for questions
        if (typeof Sortable !== 'undefined') {
            new Sortable(document.getElementById('questions-list'), {
                animation: 150,
                handle: '.question-item',
                onEnd: function() {
                    const questionIds = Array.from(document.querySelectorAll('.question-item'))
                        .map(item => item.dataset.questionId);
                    
                    // Update question order
                    fetch("{{ route('questions.reorder', $quiz) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ questions: questionIds })
                    });
                }
            });
        }
    </script>
    @endpush
</x-app-layout> 