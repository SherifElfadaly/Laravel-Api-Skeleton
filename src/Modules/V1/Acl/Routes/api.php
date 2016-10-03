<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1/acl'], function() {

	Route::group(['prefix' => 'users'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'UsersController@index');
		Route::get('find/{id}', 'UsersController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'UsersController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'UsersController@paginate');
		Route::get('delete/{id}', 'UsersController@delete');
		Route::get('account', 'UsersController@account');
		Route::get('block/{id}', 'UsersController@block');
		Route::get('unblock/{id}', 'UsersController@unblock');
		Route::get('logout', 'UsersController@logout');
		Route::get('refreshtoken', 'UsersController@refreshtoken');

		/**
		 * Post requests.
		 */
		Route::post('first', 'UsersController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'UsersController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'UsersController@paginateby');
		Route::post('save', 'UsersController@save');
		Route::post('register', 'UsersController@register');
		Route::post('login', 'UsersController@login');
		Route::post('login/social', 'UsersController@loginSocial');
		Route::post('assigngroups', 'UsersController@assigngroups');
		Route::post('sendreset', 'UsersController@sendreset');
		Route::post('resetpassword', 'UsersController@resetpassword');
		Route::post('changepassword', 'UsersController@changePassword');
	});

	Route::group(['prefix' => 'groups'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'GroupsController@index');
		Route::get('find/{id}', 'GroupsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@paginate');
		Route::get('delete/{id}', 'GroupsController@delete');	
		Route::get('users/{groupId}/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@users');

		/**
		 * Post requests.
		 */
		Route::post('first', 'GroupsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'GroupsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@paginateby');
		Route::post('save', 'GroupsController@save');
		Route::post('assignpermissions', 'GroupsController@assignpermissions');
	});	

	Route::group(['prefix' => 'permissions'], function() {
		/**
		 * Get requests.
		 */
		Route::get('/', 'PermissionsController@index');
		Route::get('find/{id}', 'PermissionsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@paginate');

		/**
		 * Post requests.
		 */
		Route::post('first', 'PermissionsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'PermissionsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@paginateby');
	});
});
