<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Quiz;

class QuizTakenController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $quizzes = Quiz::whereHas('answers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with([
            'user', // quiz maker
            'questions.options',
            'answers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])
        ->get();

        return Inertia::render('QuizTaken/Index', [
            'quizzes' => $quizzes,
        ]);
    }
}
