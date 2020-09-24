<?php

namespace Tests\Unit;

use Tests\TestCase;

class AggregatorTest extends TestCase
{    
    /**
     * Check aggregation with dummy data 1 for success
     *
     * @return void
     */
    public function testIndexSuccess1()
    {
        $input = [
            'from_date' => '2020-09-24',
            'to_date' => '2020-10-30',
            'city' => 'csd',
            'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/BestHotels', $input);
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'provider', 'hotelName', 'fare', 'amenities'
            ]
        ]);
    }

    /**
     * Check aggregation with dummy data 2 for success
     *
     * @return void
     */
    public function testIndexSuccess2()
    {
        $input = [
            'from_date' => '2020-09-24',
            'to_date' => '2020-10-30',
            'city' => 'csd',
            'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'provider', 'hotelName', 'fare', 'amenities'
            ]
        ]);
    }

    /**
     * Check aggregation with dummy data that doesn't exist for 404
     *
     * @return void
     */
    public function testNotFound()
    {
        $input = [
            'from_date' => '2020-09-24',
            'to_date' => '2020-10-30',
            'city' => 'csd',
            'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/SomeWeirdHotelThatDoesntExist', $input);
        $response->assertStatus(404);
        $response->assertNotFound();
    }

    /**
     * Check aggregation with random missing/not correct parameters.
     *
     * @return void
     */
    public function testIndexMissingParameters()
    {
        $input = [
            // 'from_date' => '2020-09-24',
            'to_date' => '2020-10-30',
            'city' => 'csd',
            'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertStatus(422);
        $input = [
            'from_date' => '2020-09-24',
            // 'to_date' => '2020-10-30',
            'city' => 'csd',
            'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertStatus(422);
        $input = [
            'from_date' => '2020-09-24',
            'to_date' => '2020-10-30',
            // 'city' => 'csd',
            'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertStatus(422);
        $input = [
            'from_date' => '2020-09-24',
            'to_date' => '2020-10-30',
            'city' => 'csd',
            // 'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertStatus(422);
        $input = [
            // 'from_date' => '2020-09-24',
            // 'to_date' => '2020-10-30',
            // 'city' => 'csd',
            // 'adults_number' => 2,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertStatus(422);
        $input = [
            'from_date' => '',
            'to_date' => '',
            'city' => '',
            'adults_number' => 0,
        ];

        $response = $this->postJson('/aggregate/TopHotel', $input);
        $response->assertStatus(422);
    }
}
