<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProvidersRequestHelper
{

    /**
     * All providers data exist in ProvidersHelper.php
     */
    public static $provider;
    
    /**
     * Send a guzzle request for the hotel provider.
     *
     * @param  Illuminate\Http\Request $request
     * @param  string $hotel
     * @return array
     */
    public static function getHotel(Request $request, $hotel)
    {
        /**
         * Get prvider data.
         */
        self::setProvider($hotel);
        // parse request keys from our parameter names to the provider's
        $input = self::getProviderRequestParameter($request->all(), $hotel);

        // send guzzle request
        $client = new Client();
        $response = $client->request('POST', self::getProviderUrl($hotel), [
            'form_params' => $input,
        ]);

        // parse and return response
        return self::parseProviderResponse($response, $hotel);
    }
    
    /**
     * Fetch provider's settings (config)
     *
     * @param  string $hotel
     * @return array
     */
    public static function setProvider($hotel)
    {
        self::$provider = ProvidersHelper::getProvider($hotel);
        if (!self::$provider) {
            abort(404);
        }
    }
    
    /**
     * Return provider's url
     *
     * @param  string $hotel
     * @return string
     */
    public static function getProviderUrl($hotel)
    {
        return self::$provider['url'];
    }
    
    /**
     * Parse and return response in our format
     *
     * @param  mixed $response
     * @param  string $hotel
     * @return array
     */
    public static function parseProviderResponse($response, $hotel)
    {
        // get json string from guzzle response and parst it to an array
        $response = json_decode($response->getBody()->getContents(), true);

        $parsing_keys = self::$provider['response'];
        $parsing_functions = self::$provider['parsers'];
        $result = [];

        

        // loop and map providers response to our format
        foreach ($response as $row) {
            $result[] = [
                'provider' => $parsing_keys['provider'],
                'hotelName' => self::runParsingFunction($parsing_functions, $parsing_keys['hotelName'], $row[$parsing_keys['hotelName']]),
                'fare' => self::runParsingFunction($parsing_functions, $parsing_keys['fare'], $row[$parsing_keys['fare']]),
                'amenities' => self::runParsingFunction($parsing_functions, $parsing_keys['amenities'], $row[$parsing_keys['amenities']]),
            ];
        }
        return $result;
    }

    /**
     * A function to check if this data type has a parser and run it    
     *
     * @param  array $parsing_functions
     * @param  string $key
     * @param  mixed $value
     * @return mixed
     */
    public static function runParsingFunction($parsing_functions, $key, $value)
    {
        if (array_key_exists($key, $parsing_functions)) {
            return $parsing_functions[$key]($value);
        }
        return $value;
    }
    
    /**
     * Parse request keys from our parameter names to the provider's
     *
     * @param  array $input
     * @param  string $hotel
     * @return array
     */
    public static function getProviderRequestParameter($input, $hotel)
    {
        $parsing_params = self::$provider['parameters'];

        return [
            $parsing_params['from_date'] => $input['from_date'],
            $parsing_params['to_date'] => $input['to_date'],
            $parsing_params['city'] => $input['city'],
            $parsing_params['adults_number'] => $input['adults_number'],
        ];
    }
}
