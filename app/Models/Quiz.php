<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['user_id', 'name', 'thumbnail_url'];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
