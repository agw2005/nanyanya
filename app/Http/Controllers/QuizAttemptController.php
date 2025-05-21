<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function start(Quiz $quiz)
    {
        if (!$quiz->is_public && $quiz->user_id !== Auth::id() && !session('quiz_' . $quiz->id . '_access')) {
            return redirect()->route('quizzes.password', $quiz);
        }

        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
        ]);

        return redirect()->route('quiz-attempts.show', $attempt);
    }

    public function show(QuizAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        if ($attempt->completed_at) {
            return redirect()->route('quiz-attempts.results', $attempt);
        }

        $quiz = $attempt->quiz->load('questions.answers');
        return view('quiz-attempts.show', compact('attempt', 'quiz'));
    }

    public function submit(Request $request, QuizAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id() || $attempt->completed_at) {
            abort(403);
        }

        $quiz = $attempt->quiz->load('questions.answers');
        $score = 0;
        $results = [];
        $answers = $request->input('answers', []);

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            
            if ($question->question_type === 'multiple_choice') {
                $correctAnswer = $question->answers()->where('is_correct', true)->first();
                $isCorrect = $userAnswer == $correctAnswer?->id;
                
                if ($isCorrect) {
                    $score += $question->points;
                }

                $results[$question->id] = [
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer?->id,
                    'is_correct' => $isCorrect,
                    'points_earned' => $isCorrect ? $question->points : 0,
                    'question_type' => 'multiple_choice',
                ];
            } else {
                // For text answers, store the response and mark for manual review
                $results[$question->id] = [
                    'user_answer' => $userAnswer,
                    'question_type' => 'text',
                    'needs_review' => true,
                    'points_possible' => $question->points,
                    'points_earned' => 0, // Will be updated after manual review
                ];
            }
        }

        DB::beginTransaction();
        try {
            $attempt->update([
                'completed_at' => now(),
                'score' => $score,
                'results' => $results,
            ]);
            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Quiz submitted successfully',
                    'redirect' => route('quiz-attempts.results', $attempt)
                ]);
            }

            return redirect()->route('quiz-attempts.results', $attempt);
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to submit quiz. Please try again.'
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to submit quiz. Please try again.']);
        }
    }

    public function results(QuizAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$attempt->completed_at) {
            return redirect()->route('quiz-attempts.show', $attempt);
        }

        $quiz = $attempt->quiz->load(['questions.answers', 'comments.user']);
        return view('quiz-attempts.results', compact('attempt', 'quiz'));
    }

    public function history()
    {
        $attempts = QuizAttempt::where('user_id', Auth::id())
            ->with(['quiz.user'])
            ->latest('started_at')
            ->paginate(10);

        return view('quiz-attempts.history', compact('attempts'));
    }
} 