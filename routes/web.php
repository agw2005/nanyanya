<?php

use App\Http\Controllers\MakeQuizController;
use App\Http\Controllers\QuizTakenController;
use App\Http\Controllers\QuizCreatedController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::get('/make', [MakeQuizController::class, 'index'])->name('make-quiz.index');
    Route::post('/make', [MakeQuizController::class, 'store'])->name('make-quiz.store');
    Route::get('/quiz-taken', [QuizTakenController::class, 'index'])->name('quiz-taken.index');
    Route::get('/quiz-created', [QuizCreatedController::class, 'index'])->name('quiz-created.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
