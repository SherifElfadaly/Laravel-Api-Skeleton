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

Route::group(['prefix' => 'oauth/clients'], function () {

    Route::get('/', 'OauthClientController@index');
    Route::get('{id}', 'OauthClientController@show');
    Route::post('/', 'OauthClientController@store');
    Route::patch('{id}', 'OauthClientController@update');
    Route::delete('{id}', 'OauthClientController@destroy');
    Route::patch('{id}/revoke', 'OauthClientController@revoke');
    Route::patch('{id}/unrevoke', 'OauthClientController@unRevoke');
});
