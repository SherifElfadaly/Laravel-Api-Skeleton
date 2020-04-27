<?php

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

Route::group(['prefix' => 'notifications'], function () {

    Route::get('/', 'NotificationController@index');
    Route::get('unread', 'NotificationController@unread');
    Route::patch('{id}/read', 'NotificationController@markAsRead');
    Route::patch('read/all', 'NotificationController@markAllAsRead');
});
