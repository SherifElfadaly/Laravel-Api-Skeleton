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

Route::group(['prefix' => 'notifications'], function () {

    Route::group(['prefix' => 'notifications'], function () {
        
        Route::get('list/{perPage?}', 'NotificationsController@list');
        Route::get('unread/{perPage?}', 'NotificationsController@unread');
        Route::get('markAsRead/{id}', 'NotificationsController@markAsRead');
        Route::get('markAllAsRead', 'NotificationsController@markAllAsRead');
    });

    Route::group(['prefix' => 'push_notification_devices'], function () {
        
        Route::get('list/{sortBy?}/{desc?}', 'PushNotificationDevicesController@index');
        Route::get('find/{id}', 'PushNotificationDevicesController@find');
        Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationDevicesController@search');
        Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationDevicesController@paginate');
        Route::get('delete/{id}', 'PushNotificationDevicesController@delete');
        Route::get('restore/{id}', 'PushNotificationDevicesController@restore');
        Route::post('first', 'PushNotificationDevicesController@first');
        Route::post('findby/{sortBy?}/{desc?}', 'PushNotificationDevicesController@findby');
        Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationDevicesController@paginateby');
        Route::post('save', 'PushNotificationDevicesController@save');
        Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationDevicesController@deleted');
        Route::post('register/device', 'PushNotificationDevicesController@registerDevice');
    });
});
