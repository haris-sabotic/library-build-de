<?php

namespace Database\Factories;

use App\Models\Rent;
use App\Models\RentStatus;
use App\Models\StatusBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RentStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rent_id' => Rent::factory()->create()->id,
            'statusBook_id' => StatusBook::all()->random()->id,
            'date' => now(),
        ];
    }
}
