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

Route::group(['prefix' => 'reports'], function () {
        
    Route::get('/', 'ReportController@index');
    Route::get('/{id}', 'ReportController@find');
    Route::post('get/{reportName}', 'ReportController@getReport');
});
