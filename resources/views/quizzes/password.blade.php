<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Private Quiz Access') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-8">
                            <h3 class="text-lg font-medium text-gray-900">{{ $quiz->title }}</h3>
                            <p class="mt-1 text-sm text-gray-600">This is a private quiz. Please enter the password to continue.</p>
                        </div>

                        <form method="POST" action="{{ route('quizzes.check-password', $quiz) }}" class="space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="password" :value="__('Quiz Password')" />
                                <x-text-input id="password" 
                                             name="password" 
                                             type="password" 
                                             class="mt-1 block w-full" 
                                             required 
                                             autofocus />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between">
                                <a href="{{ route('quizzes.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    Back to Quizzes
                                </a>
                                <x-primary-button>
                                    {{ __('Continue to Quiz') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 