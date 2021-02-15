<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Review;
use App\Models\User;
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
        $exists = Storage::exists('/covers');
        if ($exists) {
            $images = Storage::allFiles('/covers');
            Storage::delete($images);
        }

        User::factory()->has(
            Book::factory()
                ->has(Author::factory()->count(rand(1, 3)))
                ->has(Genre::factory()->count(rand(1, 6)))
                ->has(Review::factory()->count(rand(0, 10)))
                ->has(Rating::factory()->count(rand(0, 10)))
                ->count(rand(5, 10)))
            ->count(5)->create();
    }

}
