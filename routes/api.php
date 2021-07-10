<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Authentication
Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

//Vehicles
Route::get('list_vehicles','api\VehiclesController@index')->middleware('auth:api');
Route::post('create_vehicle','api\VehiclesController@store')->middleware('auth:api');
Route::get('show_vehicle','api\VehiclesController@show')->middleware('auth:api');
Route::patch('update_vehicle','api\VehiclesController@update')->middleware('auth:api');
Route::delete('delete_vehicle','api\VehiclesController@destroy')->middleware('auth:api');
Route::get('list_trucks','api\VehiclesController@indexTrucks')->middleware('auth:api');

