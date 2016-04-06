<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'api/v1/core'], function() {

	Route::group(['prefix' => 'settings'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'SettingsController@index');
		Route::get('find/{id}', 'SettingsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@paginate');

		/**
		 * Post requests.
		 */
		Route::post('first', 'SettingsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'SettingsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@paginateby');
		Route::post('save', 'SettingsController@save');
	});

	Route::group(['prefix' => 'logs'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'LogsController@index');
		Route::get('find/{id}', 'LogsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'LogsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'LogsController@paginate');

		/**
		 * Post requests.
		 */
		Route::post('first', 'LogsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'LogsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'LogsController@paginateby');
	});	
});