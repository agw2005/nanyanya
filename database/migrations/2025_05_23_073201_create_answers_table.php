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
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade')->index();
            $table->foreignId('question_id')->constrained()->onDelete('cascade')->index();
            $table->string('selected_option')->nullable(); // 'A', 'B', 'C', etc.
            $table->timestamps();
            $table->unique(['user_id', 'question_id']); // Prevent multiple answers per question by one user
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
