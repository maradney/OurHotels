<?php

namespace Database\Factories;

use App\Models\BestHotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class BestHotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BestHotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hotel' => $this->faker->secondaryAddress,
            'hotelRate' => rand(1, 5),
            'hotelFare' => rand(10, 100),
            'roomAmenities' => implode(',', $this->faker->words(rand(2, 10))),
        ];
    }
}
