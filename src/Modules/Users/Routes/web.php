<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'users'], function () {

    Route::get('/confirm/email/{token}', 'UserController@confirmEmailPage')->name('confirm_email_page');
    Route::get('/reset/password/{token}', 'UserController@resetPasswordPage')->name('reset_password_page');
});