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

Route::group(['prefix' => 'api/v1/notifications'], function() {

	Route::group(['prefix' => 'notifications'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'NotificationsController@index');
		Route::get('find/{id}', 'NotificationsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@paginate');
		Route::get('notified/{id}', 'NotificationsController@notified');
		Route::get('notifyall', 'NotificationsController@notifyall');

		/**
		 * Post requests.
		 */
		Route::post('first', 'NotificationsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'NotificationsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@paginateby');
	});

	Route::group(['prefix' => 'push_notifications'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'PushNotificationsDevicesController@index');
		Route::get('find/{id}', 'PushNotificationsDevicesController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@paginate');
		Route::get('delete/{id}', 'PushNotificationsDevicesController@delete');

		/**
		 * Post requests.
		 */
		Route::post('first', 'PushNotificationsDevicesController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@paginateby');
		Route::post('save', 'PushNotificationsDevicesController@save');
	});
});