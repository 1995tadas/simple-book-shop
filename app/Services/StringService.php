<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StringService
{

    public function uniqueSlug(Model $model, $title): string
    {
        $slug = Str::slug($title);
        $slugExists = $model::where('slug', $slug)->exists();
        if ($slugExists) {
            $lastSlug = $model::where('slug', 'regexp', '^' . $slug . '-\d+$')->orderBy('slug', 'desc')->first();
            if ($lastSlug) {
                $lastSlugCount = (string)Str::of($lastSlug->slug)->afterLast($slug . '-');
            } else {
                $lastSlugCount = 0;
            }

            $slug .= '-' . ++$lastSlugCount;
        }

        return $slug;
    }
}
