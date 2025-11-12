<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Subject extends Model
{

    use Sluggable;
    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'description'



    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
