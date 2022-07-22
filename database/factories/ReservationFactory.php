<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Galery;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'librarian_id' => User::all()->where('userType_id', '=', 2)->random()->id,
            'student_id' => User::all()->where('userType_id', '=', 3)->random()->id,
            'book_id' => Galery::factory()->create()->id,
            'reservation_date' => now()->addDays(1),
            'request_date' => now(),
            'close_date' => $this->faker->randomElement([now()->addSeconds(10), null]),
        ];
    }
}
