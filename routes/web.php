<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Quiz routes
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');
    Route::get('/quizzes/{quiz}/password', [QuizController::class, 'passwordForm'])->name('quizzes.password');
    Route::post('/quizzes/{quiz}/check-password', [QuizController::class, 'checkPassword'])->name('quizzes.check-password');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');

    // Question routes
    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/quizzes/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/quizzes/{quiz}/questions/reorder', [QuestionController::class, 'reorder'])->name('questions.reorder');

    // Quiz attempt routes
    Route::get('/quiz-attempts', [QuizAttemptController::class, 'history'])->name('quiz-attempts.history');
    Route::get('/quizzes/{quiz}/attempt', [QuizAttemptController::class, 'start'])->name('quiz-attempts.start');
    Route::get('/quiz-attempts/{attempt}', [QuizAttemptController::class, 'show'])->name('quiz-attempts.show');
    Route::post('/quiz-attempts/{attempt}/submit', [QuizAttemptController::class, 'submit'])->name('quiz-attempts.submit');
    Route::get('/quiz-attempts/{attempt}/results', [QuizAttemptController::class, 'results'])->name('quiz-attempts.results');

    // Comment routes
    Route::post('/quizzes/{quiz}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/quizzes/{quiz}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/quizzes/{quiz}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
