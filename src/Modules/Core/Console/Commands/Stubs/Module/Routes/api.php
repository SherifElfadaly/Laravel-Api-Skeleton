<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a role which
| is assigned the "api" middleware role. Enjoy building your API!
|
*/

Route::group(['prefix' => 'DummyRoutePrefix'], function () {

    Route::get('/', 'DummyController@index');
    Route::get('{id}', 'DummyController@show');
    Route::post('/', 'DummyController@store');
    Route::patch('{id}', 'DummyController@update');
    Route::delete('{id}', 'DummyController@destroy');
    Route::patch('restore/{id}', 'DummyController@restore');
});
