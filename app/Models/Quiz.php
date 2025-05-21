<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_type_id',
        'title',
        'description',
        'is_public',
        'password',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quizType(): BelongsTo
    {
        return $this->belongsTo(QuizType::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
} 