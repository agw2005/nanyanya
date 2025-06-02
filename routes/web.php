<?php

use App\Http\Controllers\MakeQuizController;
use App\Http\Controllers\QuizTakenController;
use App\Http\Controllers\QuizCreatedController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizLikeController;
use App\Http\Controllers\QuizParticipationController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/make', [MakeQuizController::class, 'index'])->name('make-quiz.index');
    Route::post('/make', [MakeQuizController::class, 'store'])->name('make-quiz.store');
    Route::get('/quiz-taken', [QuizTakenController::class, 'index'])->name('quiz-taken.index');
    Route::get('/quiz-created', [QuizCreatedController::class, 'index'])->name('quiz-created.index');
    Route::post('/quizzes/{quiz}/like', [QuizLikeController::class, 'toggle']);
    Route::get('/participate/{quiz}', [QuizParticipationController::class, 'show'])->name('participate.show');
    // Route::get('/participate', [QuizParticipationController::class, 'index'])->name('participate.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/quizzes/{quiz}/participate', [QuizParticipationController::class, 'show'])
        ->name('quizzes.participate');
    Route::post('/quizzes/{quiz}/answer', [QuizParticipationController::class, 'submitAnswer'])
        ->name('quizzes.answer');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
