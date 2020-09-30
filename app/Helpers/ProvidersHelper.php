<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProvidersHelper {

    
    /**
     * Return config of a given hotel
     * Note: when adding a new provider all parameters must exist even if empty.
     *
     * @return array
     */
    public static function getProviders()
    {
        $providers = [
            'BestHotels' => [
                'url' => 'localhost:8080/BestHotels',
                'parameters' => [ // Parameters keys and providers equivilant keys to change to
                    'from_date' => 'fromDate',
                    'to_date' => 'toDate',
                    'city' => 'city',
                    'adults_number' => 'numberOfAdults',
                ],
                'response' => [ // Response keys and our equivilant keys to change to
                    'provider' => 'BestHotels',
                    'hotelName' => 'hotel',
                    'fare' => 'hotelFare',
                    'amenities' => 'roomAmenities',
                ],
                // Provider's response keys that exist here will be passed through their respective callback
                'parsers' => [
                    'roomAmenities' => function ($value) {
                        return explode(',', $value);
                    }
                ]
            ],
            'TopHotel' => [
                'url' => 'localhost:8080/TopHotel',
                'parameters' => [
                    'from_date' => 'from',
                    'to_date' => 'to',
                    'city' => 'city',
                    'adults_number' => 'adultsCount',
                ],
                'response' => [
                    'provider' => 'TopHotel',
                    'hotelName' => 'hotelName',
                    'fare' => 'price',
                    'amenities' => 'amenities',
                ],
                'parsers' => [],
            ],
        ];

        return $providers;
    }
}