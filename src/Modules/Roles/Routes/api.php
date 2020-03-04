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

Route::group(['prefix' => 'roles'], function () {

    Route::get('/', 'RoleController@index');
    Route::get('/{id}', 'RoleController@find');
    Route::post('/', 'RoleController@insert');
    Route::put('/', 'RoleController@update');
    Route::delete('/{id}', 'RoleController@delete');
    Route::get('list/deleted', 'RoleController@deleted');
    Route::patch('restore/{id}', 'RoleController@restore');
});
