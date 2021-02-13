<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory()
            ->has(Author::factory()->count(3))
            ->has(Genre::factory()->count(9))
            ->has(Review::factory()->count(50))
            ->has(Rating::factory()->count(100))
            ->count(10)->create();
    }
}
