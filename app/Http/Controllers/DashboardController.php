<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $quizzes = Quiz::withCount('likedByUsers')
            ->with('user')
            ->get()
            ->map(function ($quiz) use ($user) {
                return [
                    'id' => $quiz->id,
                    'name' => $quiz->name,
                    'thumbnail_url' => $quiz->thumbnail_url,
                    'maker_name' => $quiz->user->name,
                    'liked' => $quiz->likedByUsers->contains($user->id),
                    'liked_by_users_count' => $quiz->liked_by_users_count,
                ];
            });

        return Inertia::render('dashboard', [
            'quizzes' => $quizzes,
        ]);

    }
}
