<?php

use Illuminate\Support\Str;

if (! function_exists('get_string_from_number')) {
    function get_string_from_number($number): string
    {
        $lookup = [
            '0' => 'zero',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
        ];

        $string_from_number = '';
        $chars = str_split(strval($number));

        foreach ($chars as $char) {
            $string_from_number = $string_from_number.$lookup[$char].' ';
        }

        return substr($string_from_number, 0, -1);
    }
}

if (! function_exists('random_float')) {
    function random_float($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}

if (! function_exists('round_review_formatted')) {
    function round_review_formatted($value)
    {
        return (string) Str::of(round($value, 1))->replace('.', '-');
    }
}

if (! function_exists('truncate')) {
    function truncate($text, $qty = 30)
    {
        return (string) Str::limit($text, $qty, ' ...');
    }
}

if (! function_exists('show_route')) {
    function show_route($model, $resource = null)
    {
        $resource = $resource ?? plural_from_model($model);

        return route("{$resource}.show", $model);
    }
}

if (! function_exists('plural_from_model')) {
    function plural_from_model($model)
    {
        $plural = Str::plural(class_basename($model));

        return Str::kebab($plural);
    }
}

if (! function_exists('getRandomIndexes')) {
    function getRandomIndexes($max, $min, $size): array
    {
        $count = 0;
        $sample = [];

        do {

            $x = rand($min, $max);

            if (! in_array($x, $sample)) {
                array_push($sample, $x);

                $count = $count + 1;
            }

        } while ($count < $size);

        return $sample;
    }
}
