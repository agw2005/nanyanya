<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quiz Taking Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Quiz Taking</h3>
                            <div class="space-y-4">
                                <a href="{{ route('quizzes.index') }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                    <h4 class="font-medium text-blue-600">Available Quizzes</h4>
                                    <p class="text-gray-600 mt-1">Browse and take available quizzes</p>
                                </a>
                                <a href="{{ route('quiz-attempts.history') }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                    <h4 class="font-medium text-blue-600">My Quiz History</h4>
                                    <p class="text-gray-600 mt-1">View your quiz attempts and results</p>
                                </a>
                            </div>
                        </div>

                        @if(auth()->user()->is_quiz_maker)
                        <!-- Quiz Making Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Quiz Making</h3>
                            <div class="space-y-4">
                                <a href="{{ route('quizzes.create') }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                    <h4 class="font-medium text-green-600">Create New Quiz</h4>
                                    <p class="text-gray-600 mt-1">Create a new quiz for others to take</p>
                                </a>
                                <a href="{{ route('quizzes.index', ['filter' => 'created']) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                    <h4 class="font-medium text-green-600">My Created Quizzes</h4>
                                    <p class="text-gray-600 mt-1">Manage your created quizzes</p>
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Statistics Section -->
                        <div class="bg-gray-50 p-6 rounded-lg md:col-span-2">
                            <h3 class="text-lg font-semibold mb-4">Statistics</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <h4 class="text-sm font-medium text-gray-600">Quizzes Taken</h4>
                                    <p class="text-2xl font-bold text-blue-600 mt-1">
                                        {{ auth()->user()->quizAttempts()->count() }}
                                    </p>
                                </div>
                                @if(auth()->user()->is_quiz_maker)
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <h4 class="text-sm font-medium text-gray-600">Quizzes Created</h4>
                                    <p class="text-2xl font-bold text-green-600 mt-1">
                                        {{ auth()->user()->quizzes()->count() }}
                                    </p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <h4 class="text-sm font-medium text-gray-600">Total Attempts on My Quizzes</h4>
                                    <p class="text-2xl font-bold text-purple-600 mt-1">
                                        {{ auth()->user()->quizzes()->withCount('attempts')->get()->sum('attempts_count') }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
