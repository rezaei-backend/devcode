<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'meta_description',
        'description',
        'logo',
        'primary_color',
        'secondary_color',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }


//    public function sluggable(): array
//    {
//        return [
//            'slug' => [
//                'source' => 'name',
//                'separator' => '-',
//                'unique' => true,
//                'includeTrashed' => false,
//                'onUpdate' => true,
//                'maxLength' => 100,
//                'method' => function (string $string, string $separator) {
//                    $slug = trim($string);
//                    $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]+/u', '', $slug);
//                    $slug = preg_replace('/[\s]+/u', $separator, $slug);
//
//                    return mb_strtolower($slug, 'UTF-8');
//                },
//            ],
//        ];
//    }

    public function getDisplayNameAttribute(): string
    {
        return match (mb_strtolower($this->name)) {
            'c#', 'c sharp', 'c-sharp' => 'C#',
            'c++', 'c plus plus', 'c-plus-plus' => 'C++',
            'js', 'javascript' => 'JavaScript',
            'ts', 'typescript' => 'TypeScript',
            'py', 'python' => 'Python',
            default => $this->name,
        };
    }


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '-',
                'unique' => true,
                'includeTrashed' => false,
                'onUpdate' => true,
                'maxLength' => 100,
                'method' => function (string $string, string $separator) {

                    $slug = trim($string);

                    // replacements for programming languages
                    $replacements = [
                        'C++' => 'C Plus Plus',
                        'c++' => 'c plus plus',
                        'C#'  => 'C Sharp',
                        'c#'  => 'c sharp',
                        '.NET' => ' Dot Net',
                    ];

                    $slug = str_replace(
                        array_keys($replacements),
                        array_values($replacements),
                        $slug
                    );

                    // remove invalid characters
                    $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\s]+/u', '', $slug);

                    // replace spaces with separator
                    $slug = preg_replace('/[\s]+/u', $separator, $slug);

                    return mb_strtolower($slug, 'UTF-8');
                },
            ],
        ];
    }




}
