<?php

use App\Http\Controllers\MakeQuizController;
use App\Http\Controllers\QuizOverviewController;
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
    Route::get('/overview', [QuizOverviewController::class, 'index'])->name('quiz-overview.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
