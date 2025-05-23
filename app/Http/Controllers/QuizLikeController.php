<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizLikeController extends Controller
{
    public function toggle(Quiz $quiz)
    {
        $user = Auth::user();
        $liked = $quiz->likedByUsers()->where('user_id', $user->id)->exists();

        if ($liked) {
            $quiz->likedByUsers()->detach($user->id);
        } else {
            $quiz->likedByUsers()->attach($user->id);
        }

        return back(); // or redirect or Inertia::visit, depending on your flow
    }
}
