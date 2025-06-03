<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index();
            $table->foreign('user_id', 'fk_answers_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreignId('quiz_id')->index();
            $table->foreign('quiz_id', 'fk_answers_quiz_id')->references('id')->on('quizzes')->onDelete('cascade');

            $table->foreignId('question_id')->index();
            $table->foreign('question_id', 'fk_answers_question_id')->references('id')->on('questions')->onDelete('cascade');

            $table->string('selected_option')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'question_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
