<?php

if (! function_exists('display_language_name')) {
    function display_language_name(string $name): string
    {
        return match (mb_strtolower(trim($name))) {
            'c#', 'c sharp', 'c-sharp' => '#C',
            'c++', 'c plus plus', 'c-plus-plus' => '++C',
            'js', 'javascript' => 'JavaScript',
            'ts', 'typescript' => 'TypeScript',
            'py', 'python' => 'Python',
            default => $name,
        };
    }
}
