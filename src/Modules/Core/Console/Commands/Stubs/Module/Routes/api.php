<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'DummyRoutePrefix'], function () {

    Route::get('/', 'DummyController@index');
    Route::get('/{id}', 'DummyController@find');
    Route::post('/', 'DummyController@insert');
    Route::put('/', 'DummyController@update');
    Route::delete('/{id}', 'DummyController@delete');
    Route::get('list/deleted', 'DummyController@deleted');
    Route::patch('restore/{id}', 'DummyController@restore');
});
