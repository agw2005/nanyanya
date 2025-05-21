<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
} 