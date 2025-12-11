<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    protected $table = 'contact_us';
    protected $fillable = ['message', 'phone', 'email' , 'status'];
}
