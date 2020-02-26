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

Route::group(['prefix' => 'acl'], function () {

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
        Route::post('assign/groups', 'UserController@assignGroups');
        Route::post('group/{groupName}', 'UserController@group');

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

    Route::group(['prefix' => 'groups'], function () {

        Route::get('/', 'GroupController@index');
        Route::get('/{id}', 'GroupController@find');
        Route::post('/', 'GroupController@insert');
        Route::put('/', 'GroupController@update');
        Route::delete('/{id}', 'GroupController@delete');
        Route::get('list/deleted', 'GroupController@deleted');
        Route::patch('restore/{id}', 'GroupController@restore');
        Route::post('assign/permissions', 'GroupController@assignPermissions');
    });
    
    Route::group(['prefix' => 'permissions'], function () {
        
        Route::get('/', 'PermissionController@index');
        Route::get('/{id}', 'PermissionController@find');
    });

    Route::group(['prefix' => 'oauth/clients'], function () {
        
        Route::get('/', 'OauthClientController@index');
        Route::get('/{id}', 'OauthClientController@find');
        Route::post('/', 'OauthClientController@insert');
        Route::put('/', 'OauthClientController@update');
        Route::get('revoke/{id}', 'OauthClientController@revoke');
        Route::get('unrevoke/{id}', 'OauthClientController@unRevoke');
    });
});
