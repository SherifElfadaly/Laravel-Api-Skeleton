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

Route::group(['prefix' => 'core'], function() {

	Route::group(['prefix' => 'settings'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'SettingsController@index');
		Route::get('find/{id}', 'SettingsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@paginate');
		Route::post('first', 'SettingsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'SettingsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@paginateby');
		Route::post('save', 'SettingsController@save');
		Route::post('save/many', 'SettingsController@saveMany');
		
	});
});
