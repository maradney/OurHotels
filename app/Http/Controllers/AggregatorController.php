<?php

namespace App\Http\Controllers;

use App\Http\Requests\AggregatorRequest;
use Illuminate\Http\Request;
use App\Helpers\ProvidersRequestHelper;

class AggregatorController extends Controller
{    
    /**
     * Display rooms for a given hotel name.
     *
     * @param  AggregatorRequest $request
     * @param  string $hotel
     * @return Illuminate\Http\Response
     */
    public function index(AggregatorRequest $request)
    {
        /**
         * Get requested hotel data
         */
        $result = ProvidersRequestHelper::getHotels($request);
        return response()->json($result);
    }
}
