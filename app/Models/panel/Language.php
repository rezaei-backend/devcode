<?php

namespace App\Models\panel;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'primary_color',
        'secondary_color',
    ];
}
