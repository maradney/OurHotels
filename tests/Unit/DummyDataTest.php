<?php

namespace Tests\Unit;

use Tests\TestCase;

class DummyDataTest extends TestCase
{
    public function testSuccess1()
    {
        $input = [
            'fromDate' => '2020-09-24',
            'toDate' => '2020-10-30',
            'city' => 'csd',
            'numberOfAdults' => 2,
        ];

        $response = $this->postJson('/BestHotels', $input);
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'hotel', 'hotelRate', 'hotelFare', 'roomAmenities'
            ]
        ]);
    }

    public function testSuccess2()
    {
        $input = [
            'from' => '2020-09-24',
            'to' => '2020-10-30',
            'city' => 'csd',
            'adultsCount' => 2,
        ];

        $response = $this->postJson('/TopHotel', $input);
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'hotelName', 'rate', 'price', 'discount', 'amenities'
            ]
        ]);
    }
}
