<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('questions.options')->get();

        return Inertia::render('dashboard', [
            'quizzes' => $quizzes,
        ]);
    }
}
