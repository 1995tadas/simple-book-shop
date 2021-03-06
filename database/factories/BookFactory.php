<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $image = $this->faker->image('storage/app/public' . '/covers', 600, 1000, 'books');

        return [
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'price' => $this->faker->randomFloat(2, 0, 5000),
            'discount' =>  $this->faker->boolean ? $this->faker->numberBetween(1, 100): 0,
            'description' => $this->faker->paragraph,
            'cover' => str_replace('storage/app/public/', '', $image),
            'approved_at' => $this->faker->boolean ? Carbon::now() : null,
            'created_at' => $this->faker->boolean ? now(): now()->subWeeks(40)
        ];
    }
}
