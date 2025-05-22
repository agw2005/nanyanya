<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MakeQuizController extends Controller
{
    public function index(){
        return Inertia::render('MakeQuiz/Index', []);
    }
}
