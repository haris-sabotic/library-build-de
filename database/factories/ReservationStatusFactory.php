<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReservationStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reservation_id' => Reservation::factory()->create()->id,
            'statusReservation_id' => $this->faker->numberBetween(1, 3),
            'date' => now(),
        ];
    }
}
