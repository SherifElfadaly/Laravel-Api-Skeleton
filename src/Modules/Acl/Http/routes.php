<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'acl'], function() {

	$apiVersion = \Request::header('api-version') ?: 1;
	Route::controllers([
		'users'       => class_exists('V' . $apiVersion . '\UsersController') ? 'V' . $apiVersion . '\UsersController' : 'V1\UsersController',
		'groups'      => 'V' . $apiVersion . '\GroupsController',
		'permissions' => 'V' . $apiVersion . '\PermissionsController'
		]);
});