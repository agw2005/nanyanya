<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuizParticipationController extends Controller
{
    public function show(Quiz $quiz){
        $quiz->load(['questions.options']); // Assuming you have `options()` in Question model

        return Inertia::render('quiz-participation', [
            'quiz' => [
                'id' => $quiz->id,
                'name' => $quiz->name,
                'questions' => $quiz->questions->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'text' => $q->text,
                        'options' => $q->options->map(fn($opt) => [
                            'id' => $opt->id,
                            'label' => $opt->label, // 'A', 'B', etc.
                            'text' => $opt->text,
                        ]),
                    ];
                }),
            ],
        ]);
    }

    public function submitAnswer(Request $request, Quiz $quiz){
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'selected_option' => 'required|string|in:A,B,C,D', // Customize if more/less options
        ]);

        $questionId = $request->question_id;
        $option = $request->selected_option;

        $user = Auth::user();

        $answer = \App\Models\Answer::updateOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'question_id' => $questionId,
            ],
            ['selected_option' => $option]
        );

        return response()->json(['status' => 'saved']);
    }
}
