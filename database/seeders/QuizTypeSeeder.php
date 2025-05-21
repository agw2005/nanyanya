<?php

namespace Database\Seeders;

use App\Models\QuizType;
use Illuminate\Database\Seeder;

class QuizTypeSeeder extends Seeder
{
    public function run(): void
    {
        $quizTypes = [
            [
                'name' => 'General Knowledge',
                'description' => 'Test your knowledge across various general topics',
            ],
            [
                'name' => 'Academic',
                'description' => 'Educational quizzes for academic subjects',
            ],
            [
                'name' => 'Technical',
                'description' => 'Technology, programming, and technical subject quizzes',
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Fun quizzes about movies, music, sports, and pop culture',
            ],
            [
                'name' => 'Language',
                'description' => 'Language learning and vocabulary quizzes',
            ],
        ];

        foreach ($quizTypes as $type) {
            QuizType::create($type);
        }
    }
} 