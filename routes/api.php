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


Route::post('register', 'API\PassportController@register');
Route::post('login', 'API\PassportController@login');

// protected routes
Route::group(['middleware' => 'auth:api'], function() {
	Route::get('countries', 'API\PassportController@getCountries');
	Route::get('country/{id}', 'API\PassportController@getCountry');

	Route::get('states/{id}', 'API\PassportController@getStates');
	Route::get('state/{id}', 'API\PassportController@getState');

	Route::get('city/{id}', 'API\PassportController@getCity');
	Route::get('cities/{id}', 'API\PassportController@getCities');
});
