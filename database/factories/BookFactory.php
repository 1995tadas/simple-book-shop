<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = $this->faker->word;
        $slug = Str::slug($title);
        $image = $this->faker->image('storage/app/public/covers', 600, 1000, 'cats');

        return [
            'title' => $title,
            'slug' => $slug,
            'price' => $this->faker->randomFloat(2, 0, 5000),
            'discount' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraph,
            'cover' => str_replace('storage/app/public/', '', $image),
            'approved' => Carbon::now(),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
