<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizCreatedController extends Controller
{
    public function index(){
        $quizzes = Quiz::with('questions.options','user')->get();

        return Inertia::render('QuizCreated/Index', [
            'quizzes' => $quizzes
        ]);
    }
}
