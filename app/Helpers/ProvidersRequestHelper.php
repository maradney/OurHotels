<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProvidersRequestHelper
{

    /**
     * All providers data exist in ProvidersHelper.php
     */
    public static $providers;
    public static $provider;

    /**
     * Send a guzzle request for the hotel provider.
     *
     * @param  Illuminate\Http\Request $request
     * @return array
     */
    public static function getHotels(Request $request)
    {
        /**
         * Get prvider data.
         */
        self::setProviders();

        $result = [];
        foreach (self::$providers as $provider_name => $provider_data) {
            self::$provider = $provider_data;
            // parse request keys from our parameter names to the provider's
            $input = self::getProviderRequestParameter($request->all(), $provider_name);

            // send guzzle request
            $client = new Client();
            $response = $client->request('POST', self::getProviderUrl($provider_name), [
                'form_params' => $input,
            ]);

            // parse provider's response and merge it to our result
            $result = array_merge($result, self::parseProviderResponse($response, $provider_name));
        }

        $sorting_key = $request->get('sort_by', 'fare');
        $sorting_method = $request->get('sort_method', 'ASC');

        if (in_array($sorting_method, ['ASC', 'asc', 1])) {
            $result = collect($result)->sortBy($sorting_key);
        } else {
            $result = collect($result)->sortByDesc($sorting_key);
        }
        return $result;
    }

    /**
     * Fetch provider's settings (config)
     *
     * @return void
     */
    public static function setProviders()
    {
        self::$providers = ProvidersHelper::getProviders();
        if (!self::$providers) {
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
