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
            ->with([
                'user',
                'questions.options',
            ])
            ->withCount(['answers as participants_count' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT user_id)'));
            }])
            ->get()
            ->map(function ($quiz) {
                $participantAnswers = DB::table('answers')
                    ->join('users', 'answers.user_id', '=', 'users.id')
                    ->where('answers.quiz_id', $quiz->id)
                    ->select('answers.user_id', 'users.name as user_name', 'answers.question_id', 'answers.selected_option')
                    ->get()
                    ->groupBy('user_id')
                    ->map(function ($answers, $userId) {
                        return [
                            'user' => [
                                'id' => $userId,
                                'name' => $answers->first()->user_name,
                            ],
                            'answers' => $answers->map(function ($a) {
                                return [
                                    'question_id' => $a->question_id,
                                    'selected_option' => $a->selected_option,
                                ];
                            })->values(),
                        ];
                    })->values();
    
                $quiz->participant_answers = $participantAnswers;
                return $quiz;
            });
    
        return Inertia::render('QuizCreated/Index', [
            'quizzes' => $quizzes,
        ]);
    }
    
    
}
