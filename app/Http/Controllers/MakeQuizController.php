<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class MakeQuizController extends Controller
{
    public function index(){
        return Inertia::render('MakeQuiz/Index', []);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|url',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*.label' => 'required|string|in:A,B,C,D',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.options.*.is_correct' => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $quiz = Quiz::create([
                'user_id' => $request->user()->id,
                'name' => $validated['name'],
                'thumbnail_url' => $validated['thumbnail_url'] ?? null,
            ]);

            foreach ($validated['questions'] as $order => $q) {
                $question = $quiz->questions()->create([
                    'question_text' => $q['question_text'],
                    'question_order' => $order,
                ]);

                foreach ($q['options'] as $option) {
                    $question->options()->create([
                        'label' => $option['label'],
                        'option_text' => $option['option_text'],
                        'is_correct' => $option['is_correct'],
                    ]);
                }
            }
        });

        return redirect()->route('quiz-created.index')->with('success', 'Quiz created successfully!');
    }
}
