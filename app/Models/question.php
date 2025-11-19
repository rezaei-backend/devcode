<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $fillable = [
        'subject_id',
        'question_text',
        'difficulty',
        'explanation',
        'is_active'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_question');
    }
}

