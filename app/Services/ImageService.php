<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageService
{

    public function crop($file, string $folder, int $width, int $height): string
    {
        $photo = Image::make($file)
            ->fit($width, $height)
            ->encode('jpg', 80);
        $name = time() . '.jpg';
        $path = $folder . $name;
        $saved = Storage::put($path, $photo);
        if (!$saved) {
            abort(404);
        }

        return $path;
    }
}
