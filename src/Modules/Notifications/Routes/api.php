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

        Route::get('/', 'NotificationController@index');
        Route::get('unread', 'NotificationController@unread');
        Route::get('read/{id}', 'NotificationController@markAsRead');
        Route::get('read/all', 'NotificationController@markAllAsRead');
    });

    Route::group(['prefix' => 'push_notification_devices'], function () {
        
        Route::get('/', 'PushNotificationDeviceController@index');
        Route::get('/{id}', 'PushNotificationDeviceController@find');
        Route::post('/', 'PushNotificationDeviceController@insert');
        Route::put('/', 'PushNotificationDeviceController@update');
        Route::delete('/{id}', 'PushNotificationDeviceController@delete');
        Route::get('list/deleted', 'PushNotificationDeviceController@deleted');
        Route::patch('restore/{id}', 'PushNotificationDeviceController@restore');
        Route::post('register/device', 'PushNotificationDeviceController@registerDevice');
    });
});
