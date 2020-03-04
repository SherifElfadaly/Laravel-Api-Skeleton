<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'groups'], function () {

    Route::get('/', 'GroupController@index');
    Route::get('/{id}', 'GroupController@find');
    Route::post('/', 'GroupController@insert');
    Route::put('/', 'GroupController@update');
    Route::delete('/{id}', 'GroupController@delete');
    Route::get('list/deleted', 'GroupController@deleted');
    Route::patch('restore/{id}', 'GroupController@restore');
    Route::post('assign/permissions', 'GroupController@assignPermissions');
});