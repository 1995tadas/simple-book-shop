<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = Storage::allFiles('/covers');
        Storage::delete($images);

        Book::factory()
            ->has(Author::factory()->count(3))
            ->has(Genre::factory()->count(9))
            ->has(Review::factory()->count(25))
            ->has(Rating::factory()->count(15))
            ->count(10)->create();
    }
}
