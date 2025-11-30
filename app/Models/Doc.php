<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{


    protected $fillable = [
        'title',
        'content',
        'example_code',
        'subject_id',
        'output',
    ];

    public function subjectjoin()
    {
        return $this->hasOne(Subject::class,'id','subject_id')->select('subjects.id','subjects.title');
    }



}
