<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use Sluggable;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'example_code',
        'subject_id',
        'output'
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
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
