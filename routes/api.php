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

Route::get('campgrounds', 'CampgroundController@index');

Route::get('campgrounds/{campground}', 'CampgroundController@show');

Route::get('campgrounds/{campgroundId}/campsites', 'CampsiteController@index');

Route::get('campgrounds/{campgroundId}/campsites/{campsite}', 'CampsiteController@show');
