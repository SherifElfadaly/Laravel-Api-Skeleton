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

Route::group(['prefix' => 'api/v1/reporting'], function() {
	
	Route::group(['prefix' => 'reports'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'ReportsController@index');
		Route::get('find/{id}', 'ReportsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@paginate');

		/**
		 * Post requests.
		 */
		Route::post('first', 'ReportsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'ReportsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@paginateby');
	});
});