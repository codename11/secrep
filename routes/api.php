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
Route::post('/logout', 'Api\AuthController@logout')->middleware('auth:api');

//Vehicles
Route::post('list_vehicles','api\VehiclesController@index')->middleware('auth:api');
Route::post('create_vehicle','api\VehiclesController@store')->middleware('auth:api');
Route::get('show_vehicle','api\VehiclesController@show')->middleware('auth:api');
Route::patch('update_vehicle','api\VehiclesController@update')->middleware('auth:api');
Route::delete('delete_vehicle','api\VehiclesController@destroy')->middleware('auth:api');

//Work organizations
Route::post('create_work_organizations','api\WorkOrganizationController@store')->middleware('auth:api');
Route::get('list_work_organizations','api\WorkOrganizationController@index')->middleware('auth:api');
Route::get('show_work_organization','api\WorkOrganizationController@show')->middleware('auth:api');
Route::patch('update_work_organization','api\WorkOrganizationController@update')->middleware('auth:api');
Route::delete('delete_work_organization','api\WorkOrganizationController@destroy')->middleware('auth:api');

//Employees
Route::post('create_employee','api\EmployeesController@store')->middleware('auth:api');
Route::get('list_employees','api\EmployeesController@index')->middleware('auth:api');
Route::get('show_employee','api\EmployeesController@show')->middleware('auth:api');
Route::patch('update_employee','api\EmployeesController@update')->middleware('auth:api');
Route::delete('delete_employee','api\EmployeesController@destroy')->middleware('auth:api');

//Deliveries
Route::post('create_delivery','api\DeliveriesController@store')->middleware('auth:api');
Route::get('list_deliveries','api\DeliveriesController@index')->middleware('auth:api');
Route::get('show_delivery','api\DeliveriesController@show')->middleware('auth:api');
Route::patch('update_delivery','api\DeliveriesController@update')->middleware('auth:api');
Route::delete('delete_delivery','api\DeliveriesController@destroy')->middleware('auth:api');

//Special_Permissions
Route::get('list_special_permissions','api\Special_PermissionsController@index')->middleware('auth:api');
Route::post('create_special_permissions','api\Special_PermissionsController@store')->middleware('auth:api');
Route::patch('update_special_permissions','api\Special_PermissionsController@update')->middleware('auth:api');
Route::get('show_special_permissions','api\Special_PermissionsController@show')->middleware('auth:api');
Route::delete('delete_special_permissions','api\Special_PermissionsController@destroy')->middleware('auth:api');

//Custom report
Route::post('getModels','api\CustomReportsController@getModels')->middleware('auth:api');
Route::post('vehicles','api\CustomReportsController@vehicles')->middleware('auth:api');
Route::post('deliveries','api\CustomReportsController@deliveries')->middleware('auth:api');
Route::post('employees','api\CustomReportsController@employees')->middleware('auth:api');
Route::post('users','api\CustomReportsController@users')->middleware('auth:api');

//Vehicle pivot: sets vehicle types
Route::get('list_vehicle_pivot','api\VehiclePivotController@index')->middleware('auth:api');
Route::post('create_vehicle_pivot','api\VehiclePivotController@store')->middleware('auth:api');
Route::patch('update_vehicle_pivot','api\VehiclePivotController@update')->middleware('auth:api');
Route::get('show_vehicle_pivot','api\VehiclePivotController@show')->middleware('auth:api');
Route::delete('delete_vehicle_pivot','api\VehiclePivotController@destroy')->middleware('auth:api');