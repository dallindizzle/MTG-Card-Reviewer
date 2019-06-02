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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List cards
Route::get('cards', 'CardsController@index');

// List singe card
Route::get('card/{id}', 'CardsController@show');

// Create new card
Route::post('card', 'CardsController@store');

// Update card
Route::put('card', 'CardsController@store');

// Delete card
Route::delete('card/{id}', 'CardsController@destroy');