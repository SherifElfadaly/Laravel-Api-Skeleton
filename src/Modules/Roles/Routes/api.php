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

Route::group(['prefix' => 'roles'], function () {

    Route::get('/', 'RoleController@index');
    Route::get('{id}', 'RoleController@show');
    Route::post('/', 'RoleController@store');
    Route::patch('{id}', 'RoleController@update');
    Route::delete('{id}', 'RoleController@destroy');
    Route::patch('{id}/restore', 'RoleController@restore');
    Route::patch('{id}/assign/permissions', 'RoleController@assignPermissions');
});
