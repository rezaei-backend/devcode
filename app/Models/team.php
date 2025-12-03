<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'resume',
        'Expertise',
        'image'
    ];


}
