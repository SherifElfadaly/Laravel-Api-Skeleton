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

Route::group(['prefix' => 'v1/notifications'], function() {

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

	Route::group(['prefix' => 'push_notifications_devices'], function() {
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
