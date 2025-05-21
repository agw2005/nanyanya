<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,text',
            'points' => 'required|integer|min:1',
            'answers' => 'required_if:question_type,multiple_choice|array|min:2',
            'answers.*.answer_text' => 'required_if:question_type,multiple_choice|string',
            'answers.*.is_correct' => 'required_if:question_type,multiple_choice|boolean',
        ]);

        try {
            $question = $quiz->questions()->create([
                'question_text' => $validated['question_text'],
                'question_type' => $validated['question_type'],
                'points' => $validated['points'],
                'order' => $quiz->questions()->count() + 1,
            ]);

            if ($validated['question_type'] === 'multiple_choice' && isset($validated['answers'])) {
                foreach ($validated['answers'] as $answerData) {
                    $question->answers()->create([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => $answerData['is_correct'],
                    ]);
                }
            }

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Question added successfully.']);
            }

            return redirect()->route('quizzes.edit', $quiz)
                ->with('success', 'Question added successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to add question.'], 500);
            }
            return back()->withErrors(['error' => 'Failed to add question.']);
        }
    }

    public function edit(Quiz $quiz, Question $question)
    {
        $this->authorize('update', $quiz);
        
        $question->load('answers');
        return response()->json([
            'question_text' => $question->question_text,
            'question_type' => $question->question_type,
            'points' => $question->points,
            'answers' => $question->question_type === 'multiple_choice' ? $question->answers : null,
        ]);
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $this->authorize('update', $quiz);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,text',
            'points' => 'required|integer|min:1',
            'answers' => 'required_if:question_type,multiple_choice|array|min:2',
            'answers.*.answer_text' => 'required_if:question_type,multiple_choice|string',
            'answers.*.is_correct' => 'required_if:question_type,multiple_choice|boolean',
        ]);

        try {
            $question->update([
                'question_text' => $validated['question_text'],
                'question_type' => $validated['question_type'],
                'points' => $validated['points'],
            ]);

            if ($validated['question_type'] === 'multiple_choice' && isset($validated['answers'])) {
                $question->answers()->delete();
                foreach ($validated['answers'] as $answerData) {
                    $question->answers()->create([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => $answerData['is_correct'],
                    ]);
                }
            } else {
                // For text questions, remove any existing answers
                $question->answers()->delete();
            }

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Question updated successfully.']);
            }

            return redirect()->route('quizzes.edit', $quiz)
                ->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to update question.'], 500);
            }
            return back()->withErrors(['error' => 'Failed to update question.']);
        }
    }

    public function destroy(Request $request, Quiz $quiz, Question $question)
    {
        $this->authorize('update', $quiz);
        
        try {
            $question->delete();
            
            // Reorder remaining questions
            $quiz->questions()
                ->where('order', '>', $question->order)
                ->decrement('order');

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Question deleted successfully.']);
            }

            return redirect()->route('quizzes.edit', $quiz)
                ->with('success', 'Question deleted successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to delete question.'], 500);
            }
            return back()->withErrors(['error' => 'Failed to delete question.']);
        }
    }

    public function reorder(Request $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'exists:questions,id',
        ]);

        try {
            foreach ($request->questions as $index => $questionId) {
                Question::where('id', $questionId)->update(['order' => $index + 1]);
            }

            return response()->json(['message' => 'Questions reordered successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to reorder questions.'], 500);
        }
    }
} 