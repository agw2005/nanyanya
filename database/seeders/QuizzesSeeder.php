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

        // 4. Repeat step 2 and 3
        $quiz = Quiz::create([
            'user_id' => $user->id,
            'name' => 'Sample Quiz 2',
            'thumbnail_url' => 'https://picsum.photos/id/2/500/300',
        ]);

        $questionsData = [
            [
                'question_text' => 'What is a spider?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Insect', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Man', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Arachnid', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Mollusc', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which is not a president of america?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Emanuel', 'is_correct' => true],
                    ['label' => 'B', 'option_text' => 'Eisenhower', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Nixon', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Obama', 'is_correct' => false],
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

        // 5. Repeat it one last time
        $quiz = Quiz::create([
            'user_id' => $user->id,
            'name' => 'Sample Quiz 3',
            'thumbnail_url' => 'https://picsum.photos/id/3/500/300',
        ]);
        
        $questionsData = [
            [
                'question_text' => 'Which one is a round number?',
                'options' => [
                    ['label' => 'A', 'option_text' => '3.14', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => '2.17', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => '98', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'i', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which is not an anime?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Avatar: The last airbender', 'is_correct' => true],
                    ['label' => 'B', 'option_text' => 'Attack on Titan', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Ultraman Rising', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Pokemon: Indigo League', 'is_correct' => false],
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

        // 6. Create second user with their quizzes
        $user2 = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        // First quiz for user2 (3 questions)
        $quiz = Quiz::create([
            'user_id' => $user2->id,
            'name' => 'Science Quiz',
            'thumbnail_url' => 'https://picsum.photos/id/4/500/300',
        ]);

        $questionsData = [
            [
                'question_text' => 'What is the chemical symbol for gold?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Ag', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Au', 'is_correct' => true],
                    ['label' => 'C', 'option_text' => 'Fe', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Cu', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'What is the hardest natural substance on Earth?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Diamond', 'is_correct' => true],
                    ['label' => 'B', 'option_text' => 'Platinum', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Quartz', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Titanium', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which planet has the most moons?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Jupiter', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Saturn', 'is_correct' => true],
                    ['label' => 'C', 'option_text' => 'Uranus', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Neptune', 'is_correct' => false],
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

        // Second quiz for user2 (4 questions)
        $quiz = Quiz::create([
            'user_id' => $user2->id,
            'name' => 'History Quiz',
            'thumbnail_url' => 'https://picsum.photos/id/5/500/300',
        ]);

        $questionsData = [
            [
                'question_text' => 'Who painted the Mona Lisa?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Vincent van Gogh', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Pablo Picasso', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Leonardo da Vinci', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Michelangelo', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'In which year did World War II end?',
                'options' => [
                    ['label' => 'A', 'option_text' => '1943', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => '1945', 'is_correct' => true],
                    ['label' => 'C', 'option_text' => '1947', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => '1950', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which ancient wonder was located in Alexandria?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Colossus of Rhodes', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Lighthouse of Alexandria', 'is_correct' => true],
                    ['label' => 'C', 'option_text' => 'Hanging Gardens', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Temple of Artemis', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Who was the first President of the United States?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Thomas Jefferson', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'John Adams', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'George Washington', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Benjamin Franklin', 'is_correct' => false],
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

        // 7. Create third user with their quizzes
        $user3 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@gmail.com',
            'password' => bcrypt('password456'),
        ]);

        // First quiz for user3 (2 questions)
        $quiz = Quiz::create([
            'user_id' => $user3->id,
            'name' => 'Geography Quiz',
            'thumbnail_url' => 'https://picsum.photos/id/6/500/300',
        ]);

        $questionsData = [
            [
                'question_text' => 'Which is the largest ocean on Earth?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Atlantic Ocean', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Indian Ocean', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Pacific Ocean', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Arctic Ocean', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which desert is the largest in the world?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Sahara Desert', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Gobi Desert', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Antarctic Desert', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Arabian Desert', 'is_correct' => false],
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

        // Second quiz for user3 (5 questions)
        $quiz = Quiz::create([
            'user_id' => $user3->id,
            'name' => 'Sports Quiz',
            'thumbnail_url' => 'https://picsum.photos/id/7/500/300',
        ]);

        $questionsData = [
            [
                'question_text' => 'In which sport would you perform a slam dunk?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Volleyball', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Basketball', 'is_correct' => true],
                    ['label' => 'C', 'option_text' => 'Tennis', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Football', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'How many players are there in a standard soccer team?',
                'options' => [
                    ['label' => 'A', 'option_text' => '9', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => '10', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => '11', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => '12', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which country won the FIFA World Cup in 2018?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Brazil', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Germany', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'France', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'Argentina', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'In tennis, what is a zero score called?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Nil', 'is_correct' => false],
                    ['label' => 'B', 'option_text' => 'Zero', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Love', 'is_correct' => true],
                    ['label' => 'D', 'option_text' => 'None', 'is_correct' => false],
                ],
            ],
            [
                'question_text' => 'Which sport uses a shuttlecock?',
                'options' => [
                    ['label' => 'A', 'option_text' => 'Badminton', 'is_correct' => true],
                    ['label' => 'B', 'option_text' => 'Tennis', 'is_correct' => false],
                    ['label' => 'C', 'option_text' => 'Squash', 'is_correct' => false],
                    ['label' => 'D', 'option_text' => 'Table Tennis', 'is_correct' => false],
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
