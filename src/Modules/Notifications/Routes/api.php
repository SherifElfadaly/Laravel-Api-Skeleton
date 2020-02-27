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

    Route::get('/', 'NotificationController@index');
    Route::get('unread', 'NotificationController@unread');
    Route::get('read/{id}', 'NotificationController@markAsRead');
    Route::get('read/all', 'NotificationController@markAllAsRead');
});
