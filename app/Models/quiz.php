<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'language_id',
        'title',
        'description',
        'duration_minutes',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}