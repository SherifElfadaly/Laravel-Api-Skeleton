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

Route::group(['prefix' => 'v1/core'], function() {

	Route::group(['prefix' => 'settings'], function() {
		
		/**
		 * @api {get} /core/settings List
		 * @apiDescription List all settings.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
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
		 * @apiName Settings
		 * @apiGroup Setting
		 *
		 * @apiSuccess {Object[]} settings List of settings.
		 * @apiSuccess {Number} settings.id Id of the setting.
		 * @apiSuccess {String} settings.name Name of the setting.
		 * @apiSuccess {String} settings.key Unique key of the setting.
		 * @apiSuccess {String} settings.value value of the setting.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "Company Name",
		 *       "key": "company_name",
		 *       "value": "Company"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/{sortBy?}/{desc?}', 'SettingsController@index');

		/**
		 * @api {get} /core/settings/find/:id Find
		 * @apiDescription Find setting with the given id.
		 * @apiParam {Number} id Unique id of the setting.
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
		 * @apiName Setting/Find
		 * @apiGroup Setting
		 *
		 * @apiSuccess {Number} id Id of the setting.
		 * @apiSuccess {String} name Name of the setting.
		 * @apiSuccess {String} key Unique key of the setting.
		 * @apiSuccess {String} value Value of the permission.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "Company Name",
		 *       "key" : "company_name",
		 *       "value": "Company"
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'SettingsController@find');

		/**
		 * @api {get} /core/settings/search/:query/:perPage/:sortBy/:desc?page=:pageNumber Search
		 * @apiDescription Search settings with the given query.
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
		 * @apiName Settings/Search
		 * @apiGroup Setting
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
		 * @apiSuccess {Number} data.id Id of the setting.
		 * @apiSuccess {String} data.name Name of the setting.
		 * @apiSuccess {String} data.key Unique key of the setting.
		 * @apiSuccess {String} data.value Value of the setting.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /core/settings/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /core/settings/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Company Name",
		 *       "key": "company_name",
		 *       "value": "Company"
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
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@search');

		/**
		 * @api {get} /core/settings/paginate/:perPage/:sortBy/:desc?page=:pageNumber Paginate
		 * @apiDescription List all settings in pages.
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
		 * @apiName Settings/Paginate
		 * @apiGroup Setting
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
		 * @apiSuccess {Number} data.id Id of the setting.
		 * @apiSuccess {String} data.name Name of the setting.
		 * @apiSuccess {String} data.key Unique key of the setting.
		 * @apiSuccess {String} data.value Value of the setting.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /core/settings/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /core/settings/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Company Name",
		 *       "key": "company_name",
		 *       "value": "Company"
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
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@paginate');

		/**
		 * @api {post} /core/settings/first First
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
		 * @apiName Settings/First
		 * @apiGroup Setting
		 *
		 * @apiSuccess {Number} id Id of the setting.
		 * @apiSuccess {String} name Name of the setting.
		 * @apiSuccess {String} key Unique key of the setting.
		 * @apiSuccess {String} value Value of the permission.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id":1,
		 *       "name": "Company Name",
		 *       "key" : "company_name",
		 *       "value": "Company"
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'SettingsController@first');

		/**
		 * @api {post} /core/settings/findby/:sortBy/:desc?page=:pageNumber Paginate Find by
		 * @apiDescription Find settings that match the given conditions.
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
		 * @apiName Settings/Find by
		 * @apiGroup Setting
		 *
		 * @apiSuccess {Object[]} settings List of settings.
		 * @apiSuccess {Number} settings.id Id of the setting.
		 * @apiSuccess {String} settings.name Name of the setting.
		 * @apiSuccess {String} settings.key Unique key of the setting.
		 * @apiSuccess {String} settings.value value of the setting.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "name": "Company Name",
		 *       "key": "company_name",
		 *       "value": "Company"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'SettingsController@findby');

		/**
		 * @api {post} /core/settings/paginateby/:perPage/:sortBy/:desc?page=:pageNumber Paginate by
		 * @apiDescription Find settings that match the given conditions in pages.
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
		 * @apiName Settings/Pagiante by
		 * @apiGroup Setting
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
		 * @apiSuccess {Number} data.id Id of the setting.
		 * @apiSuccess {String} data.name Name of the setting.
		 * @apiSuccess {String} data.key Unique key of the setting.
		 * @apiSuccess {String} data.value Value of the setting.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /core/settings/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /core/settings/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "name": "Company Name",
		 *       "key": "company_name",
		 *       "value": "Company"
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
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'SettingsController@paginateby');

		/**
		 * @api {post} /core/settings/save Save
		 * @apiDescription Save group with the given data.
		 * @apiParam {Number} id Id of the setting.
		 * @apiParam {String{..100}} name Must be string.
		 * @apiParam {String{..100}} value Must be string.
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "id": 1,
		 *       "name": "Company Name",
		 *       "value": "Company"
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
		 * @apiName Settings/Save
		 * @apiGroup Setting
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
		 * @apiError (Error 400) cannotCreateSetting Can't create new setting only update existing one.
		 * @apiError (Error 400) cannotUpdateSettingKey Can't update the setting key.
		 */
		Route::post('save', 'SettingsController@save');
	});

	Route::group(['prefix' => 'logs'], function() {

		/**
		 * @api {get} /core/logs List
		 * @apiDescription List all logs.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
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
		 * @apiName Logs
		 * @apiGroup Log
		 *
		 * @apiSuccess {Object[]} logs List of logs.
		 * @apiSuccess {Number} logs.id Id of the log.
		 * @apiSuccess {String} logs.action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} logs.item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} logs.item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} logs.user_id Id of the user preform the action.
		 * @apiSuccess {Object} logs.user Data of the user preform the action.
		 * @apiSuccess {Object} logs.item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/{sortBy?}/{desc?}', 'LogsController@index');

		/**
		 * @api {get} /core/logs/find/:id Find
		 * @apiDescription Find log with the given id.
		 * @apiParam {Number} id Unique id of the log.
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
		 * @apiName Logs/Find
		 * @apiGroup Log
		 *
		 * @apiSuccess {Number} id Id of the log.
		 * @apiSuccess {String} action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} user_id Id of the user preform the action.
		 * @apiSuccess {Object} user Data of the user preform the action.
		 * @apiSuccess {Object} item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       }
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'LogsController@find');

		/**
		 * @api {get} /core/logs/search/:query/:perPage/:sortBy/:desc?page=:pageNumber Search
		 * @apiDescription Search logs with the given query.
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
		 * @apiName Logs/Search
		 * @apiGroup Log
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
		 * @apiSuccess {Number} data.id Id of the log.
		 * @apiSuccess {String} data.action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} data.item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} data.item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} data.user_id Id of the user preform the action.
		 * @apiSuccess {Object} data.user Data of the user preform the action.
		 * @apiSuccess {Object} data.item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /core/logs/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /core/logs/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       }
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
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'LogsController@search');

		/**
		 * @api {get} /core/logs/paginate/:perPage/:sortBy/:desc?page=:pageNumber Paginate
		 * @apiDescription List all logs in pages.
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
		 * @apiName Logs/Paginate
		 * @apiGroup Log
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
		 * @apiSuccess {Number} data.id Id of the log.
		 * @apiSuccess {String} data.action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} data.item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} data.item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} data.user_id Id of the user preform the action.
		 * @apiSuccess {Object} data.user Data of the user preform the action.
		 * @apiSuccess {Object} data.item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /core/logs/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /core/logs/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       }
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
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'LogsController@paginate');

		/**
		 * @api {post} /core/logs/first First
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
		 * @apiName Logs/First
		 * @apiGroup Log
		 *
		 * @apiSuccess {Number} id Id of the log.
		 * @apiSuccess {String} action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} user_id Id of the user preform the action.
		 * @apiSuccess {Object} user Data of the user preform the action.
		 * @apiSuccess {Object} item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       }
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'LogsController@first');

		/**
		 * @api {post} /core/logs/findby/:srotBy/:desc Find by
		 * @apiDescription Find logs that match the given conditions.
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
		 * @apiName Logs/Find by
		 * @apiGroup Log
		 *
		 * @apiSuccess {Object[]} logs List of logs.
		 * @apiSuccess {Number} logs.id Id of the log.
		 * @apiSuccess {String} logs.action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} logs.item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} logs.item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} logs.user_id Id of the user preform the action.
		 * @apiSuccess {Object} logs.user Data of the user preform the action.
		 * @apiSuccess {Object} logs.item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'LogsController@findby');

		/**
		 * @api {post} /core/logs/paginateby/:perPage/:sortBy/:desc?page=:pageNumber Paginate by
		 * @apiParam {Number} [perPage] Number of rows returned per page.
		 * @apiParam {String} [sortBy] The sort field .
		 * @apiParam {Boolean} [desc] Sort descinding or ascendig.
		 * @apiParam {Number} [pageNumber] The requested page number .
		 * @apiDescription Find logs that match the given conditions in pages.
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
		 * @apiName Logs/Pagiante by
		 * @apiGroup Log
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
		 * @apiSuccess {Number} data.id Id of the log.
		 * @apiSuccess {String} data.action The action that was preformed ex: create, delete etc.
		 * @apiSuccess {String} data.item_name Name of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccess {Number} data.item_id Id of the item the action was preformed to.
		 * @apiSuccess {Number} data.user_id Id of the user preform the action.
		 * @apiSuccess {Object} data.user Data of the user preform the action.
		 * @apiSuccess {Object} data.item Data of the item the action was preformed to ex: User, Setting etc.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /core/logs/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /core/logs/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "action": "block",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "user_id": 2,
		 *       "user": {
		 *       "id":2,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John@Doe.com",
		 *       "mobile_number": "0111111111",
		 *       "blocked": 0,
		 *       "last_change_password": 2016-10-25,
		 *       },
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       }
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
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'LogsController@paginateby');
	});	
});
