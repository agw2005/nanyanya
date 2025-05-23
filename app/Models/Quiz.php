<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'thumbnail_url',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedByUsers(){
        return $this->belongsToMany(User::class, 'quiz_user_likes')->withTimestamps();
    }
    
    public function answers() {
        return $this->hasMany(Answer::class);
    }    
}


