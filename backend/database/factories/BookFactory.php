<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
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
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->company(),
            'publication_year' => $this->faker->year(),
            'isbn' => $this->faker->isbn13(),
            'genre' => $this->faker->word(),
            'status' => $this->faker->randomElement(['available', 'out_of_stock', 'coming_soon']),
            'pages' => $this->faker->numberBetween(100, 500),
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
