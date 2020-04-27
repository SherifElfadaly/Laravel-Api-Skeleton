<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a role which
| is assigned the "api" middleware role. Enjoy building your API!
|
*/

Route::group(['prefix' => 'push/notification/devices'], function () {
        
    Route::get('/', 'PushNotificationDeviceController@index');
    Route::get('{id}', 'PushNotificationDeviceController@show');
    Route::post('/', 'PushNotificationDeviceController@store');
    Route::patch('{id}', 'PushNotificationDeviceController@update');
    Route::delete('{id}', 'PushNotificationDeviceController@destroy');
    Route::patch('{id}/restore', 'PushNotificationDeviceController@restore');
    Route::post('register/device', 'PushNotificationDeviceController@registerDevice');
});
