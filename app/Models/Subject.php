<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'description',
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

    public function docjoin()
    {
        return $this->hasMany(Doc::class, 'subject_id', 'id')
            ->select('docs.id', 'docs.title', 'docs.slug', 'docs.subject_id');

    }

    public function langitem()
    {
        return $this->hasOne(Language::class, 'id', 'language_id')
                    ->select('languages.id', 'languages.name');
    }

    // App\Models\Subject.php

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
