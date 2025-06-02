<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_option' => 'nullable|string|in:A,B,C,D',
        ]);

        foreach ($request->answers as $userAnswer) {
            Answer::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'question_id' => $userAnswer['question_id'],
                ],
                [
                    'quiz_id' => $request->quiz_id,
                    'selected_option' => $userAnswer['selected_option'],
                ]
            );
        }

        return redirect()->route('quiz-taken.index')->with('success', 'Answers submitted successfully.');
    }

}
