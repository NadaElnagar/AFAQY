<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'vehicle', 'middleware' =>  'GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:5,1'], function () {
    Route::get('/', 'VehicleExpensesListController@index');
});

