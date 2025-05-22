<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizTakenController extends Controller
{
    public function index(){
        return Inertia::render('QuizTaken/Index', []);
    }
}
