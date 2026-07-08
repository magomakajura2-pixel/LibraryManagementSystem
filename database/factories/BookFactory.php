<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $copies = fake()->numberBetween(1, 5);
        return [
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->sentence(4),
            'author' => fake()->name(),
            'category_id' => null,
            'publisher' => fake()->company(),
            'published_year' => fake()->year(),
            'shelf_location' => fake()->randomLetter() . fake()->randomDigit(),
            'total_copies' => $copies,
            'available_copies' => $copies,
            'status' => 'available',
        ];
    }
}
