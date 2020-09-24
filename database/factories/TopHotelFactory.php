<?php

namespace Database\Factories;

use App\Models\TopHotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopHotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TopHotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hotelName' => $this->faker->secondaryAddress,
            'rate' => str_repeat('*', rand(1, 5)),
            'price' => rand(10, 100),
            'discount' => rand(1, 20),
            'amenities' => $this->faker->words(rand(2, 10)),
        ];
    }
}
