<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BestHotel;
use App\Models\TopHotel;

class DummyDataController extends Controller
{    
    /**
     * bestHotels
     *
     * @return Illuminate\Http\Response
     */
    public function bestHotels()
    {
        $response = BestHotel::factory()->count(10)->make();
        return response()->json($response);
    }
    
    /**
     * topHotel
     *
     * @return Illuminate\Http\Response
     */
    public function topHotel() 
    {
        $response = TopHotel::factory()->count(10)->make();
        return response()->json($response);
    }
}
