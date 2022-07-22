<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => $this->faker->name,
            'pages' => $this->faker->numberBetween(30, 1200),
            'publishYear' => $this->faker->numberBetween(1500, 2021),
            'ISBN' => $this->faker->numerify('###-#-##-######-#'),
            'quantity' => $this->faker->numberBetween(1, 100),
            'summary' => $this->faker->sentence,
            'script_id' => $this->faker->numberBetween(1,2),
            'language_id' => $this->faker->numberBetween(1,3),
            'binding_id' => $this->faker->numberBetween(1,2),
            'format_id' => $this->faker->numberBetween(1,4),
            'publisher_id' => $this->faker->numberBetween(1,2),
        ];
    }
}
