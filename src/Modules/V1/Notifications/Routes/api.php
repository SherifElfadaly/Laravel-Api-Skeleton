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

Route::group(['prefix' => 'v1/notifications'], function() {

	Route::group(['prefix' => 'notifications'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'NotificationsController@index');
		Route::get('find/{id}', 'NotificationsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@paginate');
		Route::get('notified/{id}', 'NotificationsController@notified');
		Route::get('notifyall', 'NotificationsController@notifyall');
		Route::post('first', 'NotificationsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'NotificationsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@paginateby');
	});

	Route::group(['prefix' => 'push_notifications_devices'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@index');
		Route::get('find/{id}', 'PushNotificationsDevicesController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@paginate');
		Route::get('delete/{id}', 'PushNotificationsDevicesController@delete');
		Route::get('restore/{id}', 'PushNotificationsDevicesController@restore');
		Route::post('first', 'PushNotificationsDevicesController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@paginateby');
		Route::post('save', 'PushNotificationsDevicesController@save');
		Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@deleted');
		Route::post('register/device', 'PushNotificationsDevicesController@registerDevice');
	});
});
