<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizParticipationController extends Controller
{
    public function index(){
        return Inertia::render('Participate/Index', []);
    }

    public function show(Quiz $quiz){
        $quiz->load(['questions.options']);

        return Inertia::render('Participate/Index', [
            'quiz' => $quiz,
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

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'quiz_name' => 'required|string',
            'answers' => 'required|array',
            'answers.*' => 'integer|min:0',
        ]);

        // Optionally store or evaluate answers here

        return to_route('dashboard')->with('success', 'Quiz submitted successfully!');
    }

}
