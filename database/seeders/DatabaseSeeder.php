<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::truncate();
        \App\Models\Quiz::truncate();
        \App\Models\Question::truncate();
        \App\Models\Option::truncate();

        $this->call([
            QuizzesSeeder::class,
        ]);
    }
}
