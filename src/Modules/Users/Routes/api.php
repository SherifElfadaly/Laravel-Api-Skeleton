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

Route::group(['prefix' => 'users'], function () {

    Route::get('/', 'UserController@index');
    Route::get('/{id}', 'UserController@find');
    Route::post('/', 'UserController@insert');
    Route::put('/', 'UserController@update');
    Route::delete('/{id}', 'UserController@delete');
    Route::get('list/deleted', 'UserController@deleted');
    Route::patch('restore/{id}', 'UserController@restore');
    Route::get('block/{id}', 'UserController@block');
    Route::get('unblock/{id}', 'UserController@unblock');
    Route::post('assign/roles', 'UserController@assignRoles');

    Route::group(['prefix' => 'account'], function () {

        Route::get('my', 'UserController@account');
        Route::get('logout', 'UserController@logout');
        Route::post('refresh/token', 'UserController@refreshToken');
        Route::post('save', 'UserController@saveProfile');
        Route::post('register', 'UserController@register');
        Route::post('login', 'UserController@login');
        Route::post('login/social', 'UserController@loginSocial');
        Route::post('send/reset', 'UserController@sendReset');
        Route::post('reset/password', 'UserController@resetPassword');
        Route::post('change/password', 'UserController@changePassword');
        Route::post('confirm/email', 'UserController@confirmEmail');
        Route::post('resend/email/confirmation', 'UserController@resendEmailConfirmation');
    });
});
