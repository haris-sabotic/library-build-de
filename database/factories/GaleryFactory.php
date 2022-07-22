<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Galery;
use Illuminate\Database\Eloquent\Factories\Factory;

class GaleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Galery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'book_id' => Book::factory()->create()->id,
            'photo' => 'bookDefault.png',
            'cover' => 1,
        ];
    }
}
