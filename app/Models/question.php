<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_text', 'difficulty', 'explanation', 'is_active'
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }




    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_questions');
    }
}
