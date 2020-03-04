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

Route::group(['prefix' => 'oauth/clients'], function () {
        
	Route::get('/', 'OauthClientController@index');
	Route::get('/{id}', 'OauthClientController@find');
	Route::post('/', 'OauthClientController@insert');
	Route::put('/', 'OauthClientController@update');
	Route::get('revoke/{id}', 'OauthClientController@revoke');
	Route::get('unrevoke/{id}', 'OauthClientController@unRevoke');
});
