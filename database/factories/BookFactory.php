<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'publication_year' => $this->faker->year(),
            'pages' => $this->faker->numberBetween(100, 500),
            'description' => $this->faker->text(200),
            'available_stock' => $this->faker->numberBetween(0, 20),
        ];
    }
}
