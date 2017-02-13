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
		 * @api {get} /acl/users List
		 * @apiDescription List all users.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users
		 * @apiGroup User
		 *
		 * @apiSuccess {Object[]} users List of users.
		 * @apiSuccess {Number} users.id Id of the User.
		 * @apiSuccess {String} users.name Name of the User.
		 * @apiSuccess {String} users.email Email of the User.
		 * @apiSuccess {Boolean} users.blocked User is blocked or not.
		 * @apiSuccess {Date} users.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/', 'UsersController@index');

		/**
		 * @api {get} /acl/users/find/:id Find
		 * @apiDescription Find user with the given id.
		 * @apiParam {Number} id Unique id of the user.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Find
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} id Id of the User.
		 * @apiSuccess {String} name Name of the User.
		 * @apiSuccess {String} email Email of the User.
		 * @apiSuccess {Boolean} blocked User is blocked or not.
		 * @apiSuccess {Date} last_change_password Last time the User changed password.
		 * @apiSuccess {Object[]} groups List of user groups.
		 * @apiSuccess {String} groups.name Name of the Group.
		 * @apiSuccess {Object[]} persona List of user persona.
		 * @apiSuccess {String} persona.name Name of the Persona.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       "groups" : [
		 *       {
		 *       "id": 1
		 *       "name": "Admin"
		 *       }
		 *       ]
		 *       "persona" : [
		 *       {
		 *       "id": 1
		 *       "name": "Student"
		 *       }
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'UsersController@find');

		/**
		 * @api {get} /acl/users/search/:query/:perPage/:sortBy/:desc?page=:pageNUmber Search
		 * @apiDescription Search users with the given query.
		 * @apiParam {String} [query] The search text.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Search
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data Search result.
		 * @apiSuccess {Number} data.id Id of the User.
		 * @apiSuccess {String} data.name Name of the User.
		 * @apiSuccess {String} data.email Email of the User.
		 * @apiSuccess {Boolean} data.blocked User is blocked or not.
		 * @apiSuccess {Date} data.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/users/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/users/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'UsersController@search');

		/**
		 * @api {get} /acl/users/paginate/:perPage/:sortBy/:desc?page=:pageNumber Paginate
		 * @apiDescription List all users in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Paginate
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the User.
		 * @apiSuccess {String} data.name Name of the User.
		 * @apiSuccess {String} data.email Email of the User.
		 * @apiSuccess {Boolean} data.blocked User is blocked or not.
		 * @apiSuccess {Date} data.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/users/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/users/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'UsersController@paginate');

		/**
		 * @api {get} /acl/users/delete/:id Delete
		 * @apiDescription Delete user with the given id.
		 * @apiParam {Number} id Unique id of the user.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Delete
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The user with the given id not found.
		 */
		Route::get('delete/{id}', 'UsersController@delete');

		/**
		 * @api {get} /acl/users/restore/:id Restore
		 * @apiDescription Restore deleted user with the given id.
		 * @apiParam {Number} id Unique id of the user.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Restore
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The user with the given id not found.
		 */
		Route::get('restore/{id}', 'UsersController@restore');

		/**
		 * @api {get} /acl/users/Account Account
		 * @apiDescription Get the logged in user data.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Account
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} id Id of the User.
		 * @apiSuccess {String} name Name of the User.
		 * @apiSuccess {String} email Email of the User.
		 * @apiSuccess {Boolean} blocked User is blocked or not.
		 * @apiSuccess {Date} last_change_password Last time the User changed password.
		 * @apiSuccess {Object[]} groups List of user groups.
		 * @apiSuccess {String} groups.name Name of the Group.
		 * @apiSuccess {Object[]} persona List of user persona.
		 * @apiSuccess {String} persona.name Name of the Persona.
		 * @apiSuccess {Object[]} permissions List of user permissions.
		 * @apiSuccess {String} permissions.name Name of the permission.
		 * @apiSuccess {String} permissions.model Model of the permission.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       "groups" : [
		 *       {
		 *       "id": 1
		 *       "name": "Admin"
		 *       }
		 *       ],
		 *       "persona" : [
		 *       {
		 *       "id": 1
		 *       "name": "Student"
		 *       }
		 *       ],
		 *       "permissions" : [
		 *       {
		 *       "id": 1
		 *       "name": "delete",
		 *       "model": "users"
		 *       }
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 */
		Route::get('account', 'UsersController@account');

		/**
		 * @api {get} /acl/users/block/:id Block
		 * @apiDescription Block the user with the given id.
		 * @apiParam {Number} id Unique id of the user.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Block
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The user with the given id not found.
		 */
		Route::get('block/{id}', 'UsersController@block');

		/**
		 * @api {get} /acl/users/unblock/:id Unblock
		 * @apiDescription Unblock the user with the given id.
		 * @apiParam {Number} id Unique id of the user.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Unblock
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The user with the given id not found.
		 */
		Route::get('unblock/{id}', 'UsersController@unblock');

		/**
		 * @api {get} /acl/users/logout Logout
		 * @apiDescription Logout the logged in user.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Logout
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 */
		Route::get('logout', 'UsersController@logout');

		/**
		 * @api {get} /acl/users/refreshtoken Refresh token
		 * @apiDescription Refresh the login token.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Refreshtoken
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     	"token": "token"
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 */
		Route::get('refreshtoken', 'UsersController@refreshtoken');

		/**
		 * @api {post} /acl/users/first First
		 * @apiDescription Get the first result that match the given conditions.
		 * @apiParam {object} conditions set of conditions used to fetch the data.
		 * @apiParamExample {json} email equal John@Doe.com:
		 *     {
		 *       "email": "John@Doe.com"
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com and user is blocked:
		 *     {
		 *       "and":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       }
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com or user is blocked:
		 *     {
		 *       "or":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       {
		 *     }
		 * @apiParamExample {json} email contain John:
		 *     {
		 *       "email": {
		 *       "op": "like",
		 *       "val": "%John%"
		 *       }
		 *     }
		 * @apiParamExample {json} user created after 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": ">",
		 *       "val": "2016-10-25"
		 *       }
		 *     }
		 * @apiParamExample {json} user created between 2016-10-20 and 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": "between",
		 *       "val1": "2016-10-20",
		 *       "val2": "2016-10-25"
		 *       {
		 *     }
		 * @apiParamExample {json} user id in 1,2,3:
		 *     {
		 *       "id": {
		 *       "op": "in",
		 *       "val": [1, 2, 3]
		 *     }
		 * @apiParamExample {json} user name is null:
		 *     {
		 *       "name": {
		 *       "op": "null"
		 *     }
		 * @apiParamExample {json} user name is not null:
		 *     {
		 *       "name": {
		 *       "op": "not null"
		 *     }
		 * @apiParamExample {json} user has group admin:
		 *     {
		 *       "groups": {
		 *       "op": "has",
		 *       "val": {
		 *       	"name": "Admin"
		 *       }
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/First
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} id Id of the User.
		 * @apiSuccess {String} name Name of the User.
		 * @apiSuccess {String} email Email of the User.
		 * @apiSuccess {Boolean} blocked User is blocked or not.
		 * @apiSuccess {Date} last_change_password Last time the User changed password.
		 * @apiSuccess {Object[]} persona List of user persona.
		 * @apiSuccess {String} persona.name Name of the Persona.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       "persona" : [
		 *       {
		 *       "id": 1
		 *       "name": "Student"
		 *       }
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'UsersController@first');

		/**
		 * @api {post} /acl/users/findby/:sortBy/:desc Find by
		 * @apiDescription Find users that match the given conditions.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {object} conditions set of conditions used to fetch the data.
		 * @apiParamExample {json} email equal John@Doe.com:
		 *     {
		 *       "email": "John@Doe.com"
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com and user is blocked:
		 *     {
		 *       "and":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       }
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com or user is blocked:
		 *     {
		 *       "or":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       {
		 *     }
		 * @apiParamExample {json} email contain John:
		 *     {
		 *       "email": {
		 *       "op": "like",
		 *       "val": "%John%"
		 *       }
		 *     }
		 * @apiParamExample {json} user created after 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": ">",
		 *       "val": "2016-10-25"
		 *       }
		 *     }
		 * @apiParamExample {json} user created between 2016-10-20 and 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": "between",
		 *       "val1": "2016-10-20",
		 *       "val2": "2016-10-25"
		 *       {
		 *     }
		 * @apiParamExample {json} user id in 1,2,3:
		 *     {
		 *       "id": {
		 *       "op": "in",
		 *       "val": [1, 2, 3]
		 *     }
		 * @apiParamExample {json} user name is null:
		 *     {
		 *       "name": {
		 *       "op": "null"
		 *     }
		 * @apiParamExample {json} user name is not null:
		 *     {
		 *       "name": {
		 *       "op": "not null"
		 *     }
		 * @apiParamExample {json} user has group admin:
		 *     {
		 *       "groups": {
		 *       "op": "has",
		 *       "val": {
		 *       	"name": "Admin"
		 *       }
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Find by
		 * @apiGroup User
		 *
		 * @apiSuccess {Object[]} users List of users.
		 * @apiSuccess {Number} users.id Id of the User.
		 * @apiSuccess {String} users.name Name of the User.
		 * @apiSuccess {String} users.email Email of the User.
		 * @apiSuccess {Boolean} users.blocked User is blocked or not.
		 * @apiSuccess {Date} users.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'UsersController@findby');

		/**
		 * @api {post} /acl/users/paginateby/:perPage/:sortBy/:desc?page=:pageNumber Paginate by
		 * @apiDescription Find users that match the given conditions in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiParam {object} conditions set of conditions used to fetch the data.
		 * @apiParamExample {json} email equal John@Doe.com:
		 *     {
		 *       "email": "John@Doe.com"
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com and user is blocked:
		 *     {
		 *       "and":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       }
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com or user is blocked:
		 *     {
		 *       "or":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       {
		 *     }
		 * @apiParamExample {json} email contain John:
		 *     {
		 *       "email": {
		 *       "op": "like",
		 *       "val": "%John%"
		 *       }
		 *     }
		 * @apiParamExample {json} user created after 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": ">",
		 *       "val": "2016-10-25"
		 *       }
		 *     }
		 * @apiParamExample {json} user created between 2016-10-20 and 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": "between",
		 *       "val1": "2016-10-20",
		 *       "val2": "2016-10-25"
		 *       {
		 *     }
		 * @apiParamExample {json} user id in 1,2,3:
		 *     {
		 *       "id": {
		 *       "op": "in",
		 *       "val": [1, 2, 3]
		 *     }
		 * @apiParamExample {json} user name is null:
		 *     {
		 *       "name": {
		 *       "op": "null"
		 *     }
		 * @apiParamExample {json} user name is not null:
		 *     {
		 *       "name": {
		 *       "op": "not null"
		 *     }
		 * @apiParamExample {json} user has group admin:
		 *     {
		 *       "groups": {
		 *       "op": "has",
		 *       "val": {
		 *       	"name": "Admin"
		 *       }
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Pagiante by
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the User.
		 * @apiSuccess {String} data.name Name of the User.
		 * @apiSuccess {String} data.email Email of the User.
		 * @apiSuccess {Boolean} data.blocked User is blocked or not.
		 * @apiSuccess {Date} data.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/users/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/users/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'UsersController@paginateby');

		/**
		 * @api {post} /acl/users/save Save
		 * @apiDescription Save user with the given data.
		 * @apiParam {String{..100}} [name] Must be string.
		 * @apiParam {String} email Must be email format and unique.
		 * @apiParam {String{6..}} [password]
		 * @apiParam {Array} [groups] Array of group objects, for every object if the id is given then it will be assigned if not given it will be created first then assigned.
		 * @apiParam {Array} [persona] Array of persona objects, for every object if the id is given then it will be assigned if not given it will be created first then assigned.
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "password": "123456",
		 *       "persona" : [
		 *       {
		 *       "id": 1
		 *       },
		 *       {
		 *       "name": "Student"
		 *       }
		 *       ],
		 *       "groups" : [
		 *       {
		 *       "id": 1
		 *       },
		 *       {
		 *       "name": "Author"
		 *       }
		 *       ]
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Save
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 */
		Route::post('save', 'UsersController@save');

		/**
		 * @api {post} /acl/users/profile/save Save Profile
		 * @apiDescription Save the logged in user with the given data.
		 * @apiParam {String{..100}} [name] Must be string.
		 * @apiParam {String} email Must be email format and unique.
		 * @apiParam {String{6..}} [password]
		 * @apiParam {Object} [profile] Profile object associated with the client (see profile section for validations).
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "password": "123456"
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Save Client
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 */
		Route::post('profile/save', 'UsersController@saveProfile');

		/**
		 * @api {post} /acl/users/deleted/:perPage/:sortBy/:desc?page=:pageNumber Deleted
		 * @apiDescription Find deleted users that match the given conditions in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiParam {object} conditions set of conditions used to fetch the data.
		 * @apiParamExample {json} email equal John@Doe.com:
		 *     {
		 *       "email": "John@Doe.com"
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com and user is blocked:
		 *     {
		 *       "and":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       }
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com or user is blocked:
		 *     {
		 *       "or":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       {
		 *     }
		 * @apiParamExample {json} email contain John:
		 *     {
		 *       "email": {
		 *       "op": "like",
		 *       "val": "%John%"
		 *       }
		 *     }
		 * @apiParamExample {json} user created after 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": ">",
		 *       "val": "2016-10-25"
		 *       }
		 *     }
		 * @apiParamExample {json} user created between 2016-10-20 and 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": "between",
		 *       "val1": "2016-10-20",
		 *       "val2": "2016-10-25"
		 *       {
		 *     }
		 * @apiParamExample {json} user id in 1,2,3:
		 *     {
		 *       "id": {
		 *       "op": "in",
		 *       "val": [1, 2, 3]
		 *     }
		 * @apiParamExample {json} user name is null:
		 *     {
		 *       "name": {
		 *       "op": "null"
		 *     }
		 * @apiParamExample {json} user name is not null:
		 *     {
		 *       "name": {
		 *       "op": "not null"
		 *     }
		 * @apiParamExample {json} user has group admin:
		 *     {
		 *       "groups": {
		 *       "op": "has",
		 *       "val": {
		 *       	"name": "Admin"
		 *       }
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Deleted
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the User.
		 * @apiSuccess {String} data.name Name of the User.
		 * @apiSuccess {String} data.email Email of the User.
		 * @apiSuccess {Boolean} data.blocked User is blocked or not.
		 * @apiSuccess {Date} data.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/users/deleted/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/users/deleted/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'UsersController@deleted');

		/**
		 * @api {post} /acl/users/register Register
		 * @apiDescription Register user with the given data.
		 * @apiParam {String{..100}} [name] Must be string.
		 * @apiParam {String} email Must be email format and unique.
		 * @apiParam {String{6..}} password
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "password": "123456"
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json",
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *     }
		 * @apiName Users/Register
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     	"token": "token"
		 *     }
		 * 
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 */
		Route::post('register', 'UsersController@register');

		/**
		 * @api {post} /acl/users/login Login
		 * @apiDescription Login user with the given data.
		 * @apiParam {String} email Must be email format and unique.
		 * @apiParam {String{6..}} password
		 * @apiParam {Boolean} admin Login as admin or not
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "email": "John@Doe.com",
		 *       "password": "123456",
		 *       "admin": 0
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json",
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *     }
		 * @apiName Users/Login
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     	"token": "token"
		 *     }
		 * 
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 */
		Route::post('login', 'UsersController@login');

		/**
		 * @api {post} /acl/users/login/social Login social
		 * @apiDescription Login user by social.
		 * @apiParam {String} auth_code Required if access token not given.
		 * @apiParam {String} access_token Required if auth code not given.
		 * @apiParam {String} type Must be facebook or google
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "access_token": "token"
		 *       "type": "facebook"
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json",
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *     }
		 * @apiName Users/Login/Social
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     	"token": "token"
		 *     }
		 * 
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 * @apiError (Error 400) noSocialEmail Couldn't retrieve the email.
		 * @apiError (Error 400) userAlreadyRegistered The user already register without social, try to login.
		 * @apiError (Error 400) connectionError Wrong auth code or acces token.
		 */
		Route::post('login/social', 'UsersController@loginSocial');

		/**
		 * @api {post} /acl/users/login/assigngroups Assign groups
		 * @apiDescription Assign the given group ids to the given user.
		 * @apiParam {Array} group_ids Array of group ids.
		 * @apiParam {Number} user_id The user id the groups are assigned to.
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "group_ids": [1,2,3]
		 *       "user_id": 1
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Assign groups
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} id Id of the User.
		 * @apiSuccess {String} name Full Name of the User.
		 * @apiSuccess {String} email Email of the User.
		 * @apiSuccess {Boolean} blocked User is blocked or not.
		 * @apiSuccess {Date} last_change_password Last time the User changed password.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *     }
		 *     
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('assigngroups', 'UsersController@assigngroups');

		/**
		 * @api {post} /acl/users/sendreset Send Reset Password 
		 * @apiDescription Send reset password email.
		 * @apiParam {String} email Must be email format and unique.
		 * @apiParam {String} url The url for change password form, mus be valid url.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json",
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *     }
		 * @apiName Users/Send Reset
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 * @apiError (Error 404) notFound The user with the given email not found.
		 */
		Route::post('sendreset', 'UsersController@sendreset');

		/**
		 * @api {post} /acl/users/resetpassword Reset Password 
		 * @apiDescription Reset the password.
		 * @apiParam {String} email Must be email format and unique.
		 * @apiParam {String} token The reset password token.
		 * @apiParam {String{6..}} password
		 * @apiParam {String} password_confirmation
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json",
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *     }
		 * @apiName Users/Reset Password
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 *
		 * @apiError (Error 400) invalidResetToken The reset token is invalid or expired.
		 * @apiError (Error 400) invalidResetPassword Password don't match the confirmation.
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 * @apiError (Error 404) notFound The user with the given email not found.
		 */
		Route::post('resetpassword', 'UsersController@resetpassword');
		/**
		 * @api {post} /acl/users/changepassword Change Password 
		 * @apiDescription Change the user password.
		 * @apiParam {String} old_password The reset password token.
		 * @apiParam {String{6..}} password Must equal the confirm.
		 * @apiParam {String} password_confirmation Must equal the password.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Change Password
		 * @apiGroup User
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 *
		 * @apiError (Error 400) invalidOldPassword The old password is invalid.
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 * @apiError (Error 404) notFound The user with the given email not found.
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('changepassword', 'UsersController@changePassword');

		/**
		 * @api {post} /acl/users/group/:groupName/:perPage/:sortBy/:desc?page=:pageNumber Group
		 * @apiDescription List all users in the given group.
		 * @apiParam {object} conditions set of conditions used to fetch the data.
		 * @apiParamExample {json} email equal John@Doe.com:
		 *     {
		 *       "email": "John@Doe.com"
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com and user is blocked:
		 *     {
		 *       "and":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       }
		 *     }
		 * @apiParamExample {json} email equal John@Doe.com or user is blocked:
		 *     {
		 *       "or":{
		 *       "email": "John@Doe.com",
		 *       "blocked": 1
		 *       {
		 *     }
		 * @apiParamExample {json} email contain John:
		 *     {
		 *       "email": {
		 *       "op": "like",
		 *       "val": "%John%"
		 *       }
		 *     }
		 * @apiParamExample {json} user created after 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": ">",
		 *       "val": "2016-10-25"
		 *       }
		 *     }
		 * @apiParamExample {json} user created between 2016-10-20 and 2016-10-25:
		 *     {
		 *       "created_at": {
		 *       "op": "between",
		 *       "val1": "2016-10-20",
		 *       "val2": "2016-10-25"
		 *       {
		 *     }
		 * @apiParamExample {json} user id in 1,2,3:
		 *     {
		 *       "id": {
		 *       "op": "in",
		 *       "val": [1, 2, 3]
		 *     }
		 * @apiParamExample {json} user name is null:
		 *     {
		 *       "name": {
		 *       "op": "null"
		 *     }
		 * @apiParamExample {json} user name is not null:
		 *     {
		 *       "name": {
		 *       "op": "not null"
		 *     }
		 * @apiParamExample {json} user has group admin:
		 *     {
		 *       "groups": {
		 *       "op": "has",
		 *       "val": {
		 *       	"name": "Admin"
		 *       }
		 *     }
		 * @apiParam {Number} groupName Name of the group.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Users/Group
		 * @apiGroup User
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the User.
		 * @apiSuccess {String} data.name Name of the User.
		 * @apiSuccess {String} data.email Email of the User.
		 * @apiSuccess {Boolean} data.blocked User is blocked or not.
		 * @apiSuccess {Date} data.last_change_password Last time the User changed password.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/users/paginate/:query/:groupName/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/users/paginate/:query/:groupName/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "John Doe",
		 *       "email": "John@Doe.com",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('group/{groupName}/{perPage?}/{sortBy?}/{desc?}', 'UsersController@group');
	});

	Route::group(['prefix' => 'groups'], function() {

		/**
		 * @api {get} /acl/groups List
		 * @apiDescription List all groups.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups
		 * @apiGroup Group
		 *
		 * @apiSuccess {Object[]} groups List of groups.
		 * @apiSuccess {Number} groups.id Id of the User.
		 * @apiSuccess {String} groups.name Name of the User.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "Admin"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/', 'GroupsController@index');

		/**
		 * @api {get} /acl/groups/find/:id Find
		 * @apiDescription Find group with the given id.
		 * @apiParam {Number} id Unique id of the group.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Find
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} id Id of the group.
		 * @apiSuccess {String} name Name of the group.
		 * @apiSuccess {Object[]} permissions List of group permissions.
		 * @apiSuccess {String} permissions.name Name of the permission.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "Admin",
		 *       "permissions" : [
		 *       {
		 *       "id": 1,
		 *       "name": "create",
		 *       "model": "users"
		 *       }
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'GroupsController@find');

		/**
		 * @api {get} /acl/groups/search/:query/:perPage/:sortBy/:desc?page=:pageNumber Search
		 * @apiDescription Search groups with the given query.
		 * @apiParam {String} [query] The search text.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Search
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data Search result.
		 * @apiSuccess {Number} data.id Id of the group.
		 * @apiSuccess {String} data.name Name of the group.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/groups/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/groups/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Admin"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@search');

		/**
		 * @api {get} /acl/groups/paginate/:perPage/:sortBy/:desc?page=:pageNumber Paginate
		 * @apiDescription List all groups in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Paginate
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the group.
		 * @apiSuccess {String} data.name Name of the group.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/groups/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/groups/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Admin"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@paginate');

		/**
		 * @api {get} /acl/groups/delete/:id Delete
		 * @apiDescription Delete group with the given id.
		 * @apiParam {Number} id Unique id of the group.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Delete
		 * @apiGroup Group
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The group with the given id not found.
		 */
		Route::get('delete/{id}', 'GroupsController@delete');

		/**
		 * @api {get} /acl/groups/restore/:id Restore
		 * @apiDescription restore group with the given id.
		 * @apiParam {Number} id Unique id of the group.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Restore
		 * @apiGroup Group
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The group with the given id not found.
		 */	
		Route::get('restore/{id}', 'GroupsController@restore');

		/**
		 * @api {post} /acl/groups/first First
		 * @apiDescription Get the first result that match the given conditions.
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/First
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} id Id of the group.
		 * @apiSuccess {String} name Name of the group.
		 * @apiSuccess {Object[]} permissions List of group permissions.
		 * @apiSuccess {String} permissions.name Name of the permission.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "Admin",
		 *       "permissions" : [
		 *       {
		 *       "id": 1,
		 *       "name": "create",
		 *       "model": "users"
		 *       }
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'GroupsController@first');

		/**
		 * @api {post} /acl/groups/findby Find by
		 * @apiDescription Find groups that match the given conditions.
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Find by
		 * @apiGroup Group
		 *
		 * @apiSuccess {Object[]} groups List of groups.
		 * @apiSuccess {Number} groups.id Id of the group.
		 * @apiSuccess {String} groups.name Name of the group.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "Admin"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'GroupsController@findby');

		/**
		 * @api {post} /acl/groups/paginateby/:perPage/:sortBy/:desc?page=:pageNumber Paginate by
		 * @apiDescription Find groups that match the given conditions in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Pagiante by
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the group.
		 * @apiSuccess {String} data.name Name of the group.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/groups/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/groups/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Admin"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@paginateby');

		/**
		 * @api {post} /acl/groups/save Save
		 * @apiDescription Save group with the given data.
		 * @apiParam {String{..100}} name Must be string and unique.
		 * @apiParam {Array} [users] Array of users objects, for every object if the id is given then it will be assigned if not given it will be created first then assigned.
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "name": "Admin",
		 *       "users" : [
		 *       {
		 *       "id": 1
		 *       },
		 *       {
		 *       "email": "John@Doe.com",
		 *       "password": "123456"
		 *       }
		 *       ]
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Save
		 * @apiGroup Group
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 422) validationError There was a validation error in the given inputs.
		 */
		Route::post('save', 'GroupsController@save');
		/**
		 * @api {post} /acl/groups/deleted/:perPage/:sortBy/:desc?page=:pageNumber Deleted
		 * @apiDescription Find deleted groups that match the given conditions in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Deleted
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the group.
		 * @apiSuccess {String} data.name Name of the group.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/groups/deleted/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/groups/deleted/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Admin"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'GroupsController@deleted');

		/**
		 * @api {post} /acl/groups/login/assignpermissions Assign permissions
		 * @apiDescription Assign the given permissions ids to the given group.
		 * @apiParam {Array} permission_ids Array of permission ids.
		 * @apiParam {Number} group_id The group id the permissions are assigned to.
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "permission_ids": [1,2,3]
		 *       "group_id": 1
		 *     }
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Groups/Assign permissions
		 * @apiGroup Group
		 *
		 * @apiSuccess {Number} id Id of the group.
		 * @apiSuccess {String} name Name of the group.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "Admin"
		 *     }
		 *     
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('assignpermissions', 'GroupsController@assignpermissions');
	});	
	
	Route::group(['prefix' => 'permissions'], function() {
		
		/**
		 * @api {get} /acl/permissions List
		 * @apiDescription List all permissions.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Object[]} permissions List of permissions.
		 * @apiSuccess {Number} permissions.id Id of the permission.
		 * @apiSuccess {String} permissions.name Name of the permission.
		 * @apiSuccess {String} permissions.model Model of the permission.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "create",
		 *       "model": "users"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/', 'PermissionsController@index');

		/**
		 * @api {get} /acl/permissions/find/:id Find
		 * @apiDescription Find permission with the given id.
		 * @apiParam {Number} id Unique id of the permission.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions/Find
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Number} id Id of the permission.
		 * @apiSuccess {String} name Name of the permission.
		 * @apiSuccess {String} model Model of the permission.
		 * @apiSuccess {Object[]} groups List of permission groups.
		 * @apiSuccess {String} groups.name Name of the group.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "create",
		 *       "model": "users",
		 *       "groups" : [
		 *       {
		 *       "id": 1,
		 *       "name": "Admin""
		 *       }
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'PermissionsController@find');

		/**
		 * @api {get} /acl/permissions/search/:query/:perPage/:sortBy/:desc?page=:pageNumber Search
		 * @apiDescription Search permissions with the given query.
		 * @apiParam {String} [query] The search text.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions/Search
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data Search result.
		 * @apiSuccess {Number} data.id Id of the permission.
		 * @apiSuccess {String} data.name Name of the permission.
		 * @apiSuccess {String} data.model Model of the permission.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/permissions/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/permissions/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "create"
		 *       "model": "users"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@search');

		/**
		 * @api {get} /acl/permissions/paginate/:perPage/:sortBy/:desc?page=:pageNumber Paginate
		 * @apiDescription List all permissions in pages.
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions/Paginate
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the permission.
		 * @apiSuccess {String} data.name Name of the permission.
		 * @apiSuccess {String} data.model Model of the permission.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/permissions/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/permissions/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "create",
		 *       "model": "users"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@paginate');

		/**
		 * @api {post} /acl/permissions/first First
		 * @apiDescription Get the first result that match the given conditions.
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions/First
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Number} id Id of the permission.
		 * @apiSuccess {String} name Name of the permission.
		 * @apiSuccess {String} model Model of the permission.
		 * @apiSuccess {Object[]} groups List of permission groups.
		 * @apiSuccess {String} groups.name Name of the group.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "create",
		 *       "model": "users",
		 *       "groups" : [
		 *       {
		 *       "id": 1,
		 *       "name": "Admin"
		 *       }
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'PermissionsController@first');

		/**
		 * @api {post} /acl/permissions/findby Find by
		 * @apiDescription Find permissions that match the given conditions.
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions/Find by
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Object[]} permissions List of permissions.
		 * @apiSuccess {Number} permissions.id Id of the permission.
		 * @apiSuccess {String} permissions.name Name of the permission.
		 * @apiSuccess {String} permissions.model Model of the permission.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "create",
		 *       "model": "users"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'PermissionsController@findby');

		/**
		 * @api {post} /acl/permissions/paginateby/:perPage/:sortBy/:desc?page=:pageNumber
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig. Paginate by
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiDescription Find permissions that match the given conditions in pages.
		 * @apiParam {object} conditions set of conditions used to fetch the data, for examples check User section.
		 * @apiHeader {String} Accept The accept type.
		 * @apiHeader {String} Content-Type The content type.
		 * @apiHeader {String} locale The language of the returned data (ar, en, all).
		 * @apiHeader {String} Authorization The login token.
		 * @apiHeaderExample {json} Header-Example:
		 *     {
		 *       "Accept": "application-json"
		 *       "Content-Type": "application-json"
		 *       "locale": "en"
		 *       "Authorization": "bearer token"
		 *     }
		 * @apiName Permissions/Pagiante by
		 * @apiGroup Permission
		 *
		 * @apiSuccess {Number} total Total number of results.
		 * @apiSuccess {Number} per_page Number of results per page.
		 * @apiSuccess {Number} current_page Current page number.
		 * @apiSuccess {Number} last_page Last page number.
		 * @apiSuccess {String} next_page_url The url of the next page.
		 * @apiSuccess {String} prev_page_url The url of the pervious page.
		 * @apiSuccess {String} from Index of the first result to all data.
		 * @apiSuccess {String} to Index of the last result to all data.
		 * @apiSuccess {Object[]} data result.
		 * @apiSuccess {Number} data.id Id of the permission.
		 * @apiSuccess {String} data.name Name of the permission.
		 * @apiSuccess {String} data.model Model of the permission.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/permissions/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/permissions/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "create",
		 *       "name": "users"
		 *       },
		 *       .
		 *       .
		 *       .
		 *       .
		 *       ]
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PermissionsController@paginateby');
	});
});
