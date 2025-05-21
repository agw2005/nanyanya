<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class QuizMakerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_quiz_maker) {
            return redirect()->route('dashboard')
                ->with('error', 'You must be a quiz maker to access this page.');
        }

        return $next($request);
    }
} 