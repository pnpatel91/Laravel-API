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

Route::post('register', 'App\Http\Controllers\API\UserController@register');
Route::post('login', 'App\Http\Controllers\API\UserController@login');

Route::middleware('auth:api')->group( function () {
    Route::get('cars', 'App\Http\Controllers\API\CarController@index');
    Route::post('cars/create', 'App\Http\Controllers\API\CarController@store');
    Route::get('cars/{id}', 'App\Http\Controllers\API\CarController@show');
    Route::post('cars/{id}/edit', 'App\Http\Controllers\API\CarController@update');
    Route::delete('cars/{id}', 'App\Http\Controllers\API\CarController@destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});