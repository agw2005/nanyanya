<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizCreatedController extends Controller
{
    public function index() {
        $user = Auth::user();
    
        $quizzes = Quiz::where('user_id', $user->id)
            ->with(['user', 'questions.options'])
            ->withCount(['answers as participants_count' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT user_id)'));
            }])
            ->get();
    
        return Inertia::render('QuizCreated/Index', [
            'quizzes' => $quizzes,
        ]);
    }
    
}
