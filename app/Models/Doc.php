<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'example_code',
        'subject_id',
        'output',
        'image'
    ];

    // این رابطه اصلی و استاندارد است
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
