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

Route::group(['prefix' => 'v1/acl'], function() {

	Route::group(['prefix' => 'users'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'UsersController@index');
		Route::get('find/{id}', 'UsersController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'UsersController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'UsersController@paginate');
		Route::get('delete/{id}', 'UsersController@delete');
		Route::get('restore/{id}', 'UsersController@restore');
		Route::get('account', 'UsersController@account');
		Route::get('block/{id}', 'UsersController@block');
		Route::get('unblock/{id}', 'UsersController@unblock');
		Route::get('logout', 'UsersController@logout');
		Route::get('refreshtoken/{refreshToken}', 'UsersController@refreshtoken');
		Route::post('first', 'UsersController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'UsersController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'UsersController@paginateby');
		Route::post('save', 'UsersController@save');
		Route::post('profile/save', 'UsersController@saveProfile');
		Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'UsersController@deleted');
		Route::post('register', 'UsersController@register');
		Route::post('login', 'UsersController@login');
		Route::post('login/social', 'UsersController@loginSocial');
		Route::post('assigngroups', 'UsersController@assigngroups');
		Route::post('sendreset', 'UsersController@sendreset');
		Route::post('resetpassword', 'UsersController@resetpassword');
		Route::post('changepassword', 'UsersController@changePassword');
		Route::post('group/{groupName}/{perPage?}/{sortBy?}/{desc?}', 'UsersController@group');

	});

	Route::group(['prefix' => 'groups'], function() {

		Route::get('list/{sortBy?}/{desc?}', 'GroupsController@index');
		Route::get('find/{id}', 'GroupsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@paginate');
		Route::get('delete/{id}', 'GroupsController@delete');
		Route::get('restore/{id}', 'GroupsController@restore');
		Route::post('first', 'GroupsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'GroupsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@paginateby');
		Route::post('save', 'GroupsController@save');
		Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@deleted');
		Route::post('assignpermissions', 'GroupsController@assignpermissions');

	});	
	
	Route::group(['prefix' => 'permissions'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'PermissionsController@index');
		Route::get('find/{id}', 'PermissionsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@paginate');
		Route::post('first', 'PermissionsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'PermissionsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@paginateby');

	});

	Route::group(['prefix' => 'oauth/clients'], function() {
		
		Route::get('list/{sortBy?}/{desc?}', 'OauthClientsController@index');
		Route::get('find/{id}', 'OauthClientsController@find');
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'OauthClientsController@search');
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'OauthClientsController@paginate');
		Route::get('revoke/{id}', 'OauthClientsController@revoke');
		Route::post('first', 'OauthClientsController@first');
		Route::post('findby/{sortBy?}/{desc?}', 'OauthClientsController@findby');
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'OauthClientsController@paginateby');
		Route::post('save', 'OauthClientsController@save');

	});
});
