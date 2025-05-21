<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Quiz::with(['user', 'quizType'])
            ->withCount(['attempts', 'comments']);

        if ($request->filter === 'created') {
            $query->where('user_id', auth()->id());
        } else {
            $query->where(function($q) {
                $q->where('is_public', true)
                  ->orWhere('user_id', auth()->id());
            });
        }

        $quizzes = $query->latest()->paginate(10);

        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $this->authorize('create', Quiz::class);
        $quizTypes = QuizType::all();
        return view('quizzes.create', compact('quizTypes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Quiz::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quiz_type_id' => 'required|exists:quiz_types,id',
            'is_public' => 'required|boolean',
            'password' => 'nullable|required_if:is_public,false|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['user_id'] = auth()->id();
        $quiz = Quiz::create($validated);

        return redirect()->route('quizzes.edit', $quiz)
            ->with('success', 'Quiz created successfully. Now add some questions!');
    }

    public function show(Quiz $quiz)
    {
        if (!$quiz->is_public && $quiz->user_id !== auth()->id() && !session('quiz_' . $quiz->id . '_access')) {
            return redirect()->route('quizzes.password', $quiz);
        }

        $quiz->load(['questions.answers', 'comments.user', 'user']);
        $userAttempts = auth()->user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->get();

        return view('quizzes.show', compact('quiz', 'userAttempts'));
    }

    public function edit(Quiz $quiz)
    {
        $this->authorize('update', $quiz);
        
        $quiz->load(['questions.answers']);
        $quizTypes = QuizType::all();
        
        return view('quizzes.edit', compact('quiz', 'quizTypes'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quiz_type_id' => 'required|exists:quiz_types,id',
            'is_public' => 'required|boolean',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } elseif (isset($validated['password'])) {
            unset($validated['password']);
        }

        $quiz->update($validated);

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $this->authorize('delete', $quiz);
        
        $quiz->delete();
        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    public function checkPassword(Request $request, Quiz $quiz)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $quiz->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        session(['quiz_' . $quiz->id . '_access' => true]);
        return redirect()->route('quizzes.show', $quiz);
    }

    public function passwordForm(Quiz $quiz)
    {
        if ($quiz->is_public || $quiz->user_id === auth()->id()) {
            return redirect()->route('quizzes.show', $quiz);
        }

        return view('quizzes.password', compact('quiz'));
    }
} 