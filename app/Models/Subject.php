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
                'source' => 'title',
                'separator' => '-',
                'unique' => true,

            ],

        ];
    }
    public function joinresource()
    {
        return $this->hasOne(  resource::class, 'subject_id', 'id')->select('id','title','url');
    }
    public function docjoin(){

        return $this->hasMany(Doc::class,'subject_id', 'id')->select('docs.id', 'docs.title' );
    }
    public function langitem(){
        return $this->hasOne(Language::class,'id','language_id')->select('languages.id','languages.name');
    }
}
