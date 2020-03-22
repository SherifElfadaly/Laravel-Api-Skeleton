<?php

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

Route::group(['prefix' => 'settings'], function () {
        
    Route::get('/', 'SettingController@index');
    Route::get('/{id}', 'SettingController@find');
    Route::put('/', 'SettingController@update');
    Route::delete('/{id}', 'SettingController@delete');
    Route::get('list/deleted', 'SettingController@deleted');
    Route::patch('restore/{id}', 'SettingController@restore');
    Route::post('save/many', 'SettingController@saveMany');
});
