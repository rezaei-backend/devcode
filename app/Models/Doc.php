<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
use Sluggable;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'example_code',
        'subject_id',
        'output',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'separator' => '-',
                'unique' => true,

            ],

        ];
    }
    public function subjectjoin()
    {
        return $this->hasOne(Subject::class,'id','subject_id')->select('subjects.id','subjects.title');
    }



}
