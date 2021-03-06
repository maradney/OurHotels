<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () { // You have to specify the namespace in laravel 8 apparently.
    /**
     * Our main aggregation function
     */
    Route::post('/hotels', 'AggregatorController@index');

    /**
     * Dummy data routes for testing
     * Remember to add to VerifyCsrfToken except array when adding more.
     */
    Route::post('/BestHotels', 'Testing\DummyDataController@bestHotels');
    Route::post('/TopHotel', 'Testing\DummyDataController@topHotel');
});

Route::get('/', function () {
    return view('welcome');
});
