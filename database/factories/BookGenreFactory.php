<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookGenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookGenre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'genre_id' => Genre::all()->random()->id,
            'book_id' => Book::all()->random()->id,
        ];
    }
}
