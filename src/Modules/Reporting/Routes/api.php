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

Route::group(['prefix' => 'reporting'], function() {
	
	Route::group(['prefix' => 'reports'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'ReportsController@index');
		Route::get('find/{id}', 'ReportsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@paginate');
		Route::post('first', 'ReportsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'ReportsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@paginateby');
		Route::post('get/{reportName}/{perPage?}', 'ReportsController@getReport');
	});
});