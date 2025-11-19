<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use Sluggable;
    protected $fillable=['name','slug','meta_description','description','logo','primary_color','secondary_color'];



    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'method' => function(string $string, string $separator) {
                    $slug = trim($string);
                    $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]+/u', '', $slug);
                    $slug = preg_replace('/[\s]+/u', $separator, $slug);
                    return mb_strtolower($slug, 'UTF-8');
                },
                'separator' => '-',
                'unique' => true,
                'includeTrashed' => false,
                'onUpdate' => true,
                'maxLength' => 100 // محدودیت طول slug
            ]
        ];
    }
}


