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
        $directory = '/covers';
        $exists = Storage::exists($directory);
        if (!$exists) {
            Storage::makeDirectory($directory);
        }

        $users = User::all();
        $genres = Genre::all();
        $authors = Author::all();
        Book::factory(['user_id' => $users->random()->first()->id])
            ->count(round(75, 125))->create()->each(
            function ($book) use ($users, $genres, $authors) {
                $randomGenres = $genres->random(rand(1, 6));
                $book->genres()->saveMany($randomGenres);

                $authorsIds = $authors->random(rand(1, 3))->pluck('id');
                $book->authors()->attach($authorsIds);

                $randomUsers = $users->random(rand(10, 25));
                for ($i = 0; $i < $randomUsers->count(); $i++) {
                    Rating::factory([
                        'book_id' => $book->id,
                        'user_id' => $randomUsers->skip($i)->first()->id
                    ])->create();
                }
                for ($i = 0; $i < $randomUsers->count(); $i++) {
                    Review::factory([
                        'book_id' => $book->id,
                        'user_id' => $randomUsers->skip($i)->first()->id
                    ])->create();
                }
            }
        );
    }

}
