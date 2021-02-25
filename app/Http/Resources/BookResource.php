<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Keeps track of the current mode.
     * @var string
     */
    public static $mode = 'book';

    /**
     * Set the current mode for this resource.
     * @param $mode
     */
    public static function setMode($mode): string
    {
        self::$mode = $mode;
        return __CLASS__;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cover' => $this->cover,
            'price' => $this->price,
            'description' => $this->when(self::$mode === 'book', $this->description),
            'authors' => $this->authors->implode('name', ', '),
            'genres' => $this->genres->implode('title', ', '),
        ];
    }
}
