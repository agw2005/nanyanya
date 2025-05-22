<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Seeder;

class QuizzesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a user
        $user = User::create([
            'name' => '1234567890',
            'email' => '1234567890@gmail.com',
            'password' => bcrypt('1234567890'), // Always hash passwords
        ]);

        // 2. Create a quiz
        $quiz = Quiz::create([
            'user_id' => $user->id,
            'name' => 'Sample Quiz',
            'thumbnail_url' => 'https://picsum.photos/id/1/500/300',
        ]);

        // 3. Add questions to quiz
        $questionsData = [
            [
                'question_text' => 'What is the capital of France?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Berlin', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Madrid', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Paris', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Rome', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which planet is known as the Red Planet?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Earth', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Mars', 'is_correct' => true],
                    ['label' => 'C', 'option_text' => 'Jupiter', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Saturn', 'is_correct' => false],
                ],
            ],
        ];

        foreach ($questionsData as $index => $qData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $qData['question_text'],
                'question_order' => $index + 1,
            ]);

            foreach ($qData['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'label' => $opt['label'],
                    'option_text' => $opt['option_text'],
                    'is_correct' => $opt['is_correct'],
                ]);
            }
        }
    }
}
