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

Route::group(['prefix' => 'v1/notifications'], function() {

	Route::group(['prefix' => 'notifications'], function() {
		
		/**
		 * @api {get} /notifications/notifications List
		 * @apiDescription List all notifications.
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
		 * @apiName Notifications
		 * @apiGroup Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Object[]} notifications List of notifications.
		 * @apiSuccess {Number} notifications.id Id of the notification.
		 * @apiSuccess {String} notifications.key Unique key of the notification.
		 * @apiSuccess {String} notifications.description The description of the notification.
		 * @apiSuccess {String} notifications.item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} notifications.item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} notifications.notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
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
		Route::get('/', 'NotificationsController@index');

		/**
		 * @api {get} /notifications/notifications/find/:id Find
		 * @apiDescription Find notification with the given id.
		 * @apiParam {Number} id Unique id of the notification.
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
		 * @apiName Notifications/Find
		 * @apiGroup Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Number} id Id of the notification.
		 * @apiSuccess {String} key Unique key of the notification.
		 * @apiSuccess {String} description The description of the notification.
		 * @apiSuccess {String} item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
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
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'NotificationsController@find');

		/**
		 * @api {get} /notifications/notifications/search/:query/:perPage/:sortBy/:desc?page=:pageNUmber Search
		 * @apiDescription Search notifications with the given query.
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
		 * @apiName Notifications/Search
		 * @apiGroup Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the notification.
		 * @apiSuccess {String} data.key Unique key of the notification.
		 * @apiSuccess {String} data.description The description of the notification.
		 * @apiSuccess {String} data.item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} data.item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} data.notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/notifications/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/notifications/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       },
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
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@search');

		/**
		 * @api {get} /notifications/notifications/paginate/:perPage/:sortBy/:desc?page=:pageNUmber Paginate
		 * @apiDescription List all notifications in pages.
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
		 * @apiName Notifications/Paginate
		 * @apiGroup Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the notification.
		 * @apiSuccess {String} data.key Unique key of the notification.
		 * @apiSuccess {String} data.description The description of the notification.
		 * @apiSuccess {String} data.item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} data.item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} data.notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/notifications/pagiante/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/notifications/pagiante/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       },
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
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@paginate');

		/**
		 * @api {get} /notifications/notifications/notified/:id Notified
		 * @apiDescription Marke notification with the given id as notified.
		 * @apiParam {Number} id Unique id of the notification.
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
		 * @apiName Notifications/Notified
		 * @apiGroup Notification
		 * @apiPermission Admin
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
		Route::get('notified/{id}', 'NotificationsController@notified');

		/**
		 * @api {get} /notifications/notifications/notifyall Notify all
		 * @apiDescription Marke all notification as notified.
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
		 * @apiName Notifications/Notify all
		 * @apiGroup Notification
		 * @apiPermission Admin
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
		Route::get('notifyall', 'NotificationsController@notifyall');

		/**
		 * @api {post} /notifications/notifications/first First
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
		 * @apiName  Notifications/First
		 * @apiGroup Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Number} id Id of the notification.
		 * @apiSuccess {String} key Unique key of the notification.
		 * @apiSuccess {String} description The description of the notification.
		 * @apiSuccess {String} item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
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
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'NotificationsController@first');

		/**
		 * @api {post} /notifications/notifications/:sortBy/:descfindby Find by
		 * @apiDescription Find notifications that match the given conditions.
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
		 * @apiName Notifications/Find by
		 * @apiGroup Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Object[]} notifications List of notifications.
		 * @apiSuccess {Number} notifications.id Id of the notification.
		 * @apiSuccess {String} notifications.key Unique key of the notification.
		 * @apiSuccess {String} notifications.description The description of the notification.
		 * @apiSuccess {String} notifications.item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} notifications.item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} notifications.notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
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
		Route::post('findby/{sortBy?}/{desc?}', 'NotificationsController@findby');

		/**
		 * @api {post} /notifications/notifications/paginateby/:perPage/:sortBy/:desc?page=:pageNUmber Paginate by
		 * @apiDescription Find notifications that match the given conditions in pages.
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
		 * @apiName Notifications/Pagiante by
		 * @apiGroup Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the notification.
		 * @apiSuccess {String} data.key Unique key of the notification.
		 * @apiSuccess {String} data.description The description of the notification.
		 * @apiSuccess {String} data.item_name Name of the item that has the notification to ex: User, Setting etc.
		 * @apiSuccess {Number} data.item_id Id of the item that has the notification.
		 * @apiSuccess {Boolean} data.notified Notified or not.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/notifications/paginateby/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/notifications/paginateby/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "key": "user_block",
		 *       "description": "User has been blocked",
		 *       "item_name": "User",
		 *       "item_id": 1,
		 *       "notified": 0,
		 *       "item": {
		 *       "id":1,
		 *       "full_name": "John",
		 *       "user_name": "Doe",
		 *       "email": "John2@Doe.com",
		 *       "mobile_number": "011111211",
		 *       "blocked": 1,
		 *       "last_change_password": 2016-10-25,
		 *       },
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
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'NotificationsController@paginateby');
	});

	Route::group(['prefix' => 'push_notifications_devices'], function() {
		
		/**
		 * @api {get} /notifications/push_notifications_devices List
		 * @apiDescription List all devices.
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
		 * @apiName Devices
		 * @apiGroup Push Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Object[]} devices List of devices.
		 * @apiSuccess {Number} devices.id Id of the device.
		 * @apiSuccess {String} devices.device_token Token of the device.
		 * @apiSuccess {String} devices.device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} devices.active The device is active or not.
		 * @apiSuccess {String} devices.user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/', 'PushNotificationsDevicesController@index');

		/**
		 * @api {get} /notifications/push_notifications_devices/find/:id Find
		 * @apiDescription Find device with the given id.
		 * @apiParam {Number} id Unique id of the device.
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
		 * @apiName Devices/Find
		 * @apiGroup Push Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Number} id Id of the device.
		 * @apiSuccess {String} device_token Token of the device.
		 * @apiSuccess {String} device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} active The device is active or not.
		 * @apiSuccess {String} user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'PushNotificationsDevicesController@find');

		/**
		 * @api {get} /notifications/push_notifications_devices/search/:query/:perPage/:sortBy/:desc?page=:pageNUmber Search
		 * @apiDescription Search devices with the given query.
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
		 * @apiName Devices/Search
		 * @apiGroup Push Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the device.
		 * @apiSuccess {String} data.device_token Token of the device.
		 * @apiSuccess {String} data.device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} data.active The device is active or not.
		 * @apiSuccess {String} data.user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/devices/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/devices/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
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
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@search');

		/**
		 * @api {get} /notifications/push_notifications_devices/paginate/:perPage/:sortBy/:desc?page=:pageNUmber Paginate
		 * @apiDescription List all devices in pages.
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
		 * @apiName Devices/Paginate
		 * @apiGroup Push Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the device.
		 * @apiSuccess {String} data.device_token Token of the device.
		 * @apiSuccess {String} data.device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} data.active The device is active or not.
		 * @apiSuccess {String} data.user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/devices/paginate/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/devices/paginate/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
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
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@paginate');

		/**
		 * @api {get} /notifications/push_notifications_devices/delete/:id Delete
		 * @apiDescription Delete device with the given id.
		 * @apiParam {Number} id Unique id of the device.
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
		 * @apiName Devices/Delete
		 * @apiGroup Push Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The device with the given id not found.
		 */
		Route::get('delete/{id}', 'PushNotificationsDevicesController@delete');

		/**
		 * @api {get} /notifications/push_notifications_devices/restore/:id Restore
		 * @apiDescription Restore deleted device with the given id.
		 * @apiParam {Number} id Unique id of the device.
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
		 * @apiName Devices/Restore
		 * @apiGroup Push Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The device with the given id not found.
		 */
		Route::get('restore/{id}', 'PushNotificationsDevicesController@restore');

		/**
		 * @api {post} /notifications/push_notifications_devices/first First
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
		 * @apiName Devices/First
		 * @apiGroup Push Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Number} id Id of the device.
		 * @apiSuccess {String} device_token Token of the device.
		 * @apiSuccess {String} device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} active The device is active or not.
		 * @apiSuccess {String} user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'PushNotificationsDevicesController@first');

		/**
		 * @api {post} /notifications/push_notifications_devices/findby/:sortBy/:desc Find by
		 * @apiDescription Find devices that match the given conditions.
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
		 * @apiName Devices/Find by
		 * @apiGroup Push Notification
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Object[]} devices List of devices.
		 * @apiSuccess {Number} devices.id Id of the device.
		 * @apiSuccess {String} devices.device_token Token of the device.
		 * @apiSuccess {String} devices.device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} devices.active The device is active or not.
		 * @apiSuccess {String} devices.user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@findby');

		/**
		 * @api {post} /notifications/push_notifications_devices/paginateby/:perPage/:sortBy/:desc?page=:pageNUmber Paginate by
		 * @apiDescription Find devices that match the given conditions in pages.
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
		 * @apiName Devices/Pagiante by
		 * @apiGroup Push Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the device.
		 * @apiSuccess {String} data.device_token Token of the device.
		 * @apiSuccess {String} data.device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} data.active The device is active or not.
		 * @apiSuccess {String} data.user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/devices/paginateby/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/devices/paginateby/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
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
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@paginateby');

		/**
		 * @api {post} /notifications/push_notifications_devices/save Save
		 * @apiDescription Save device with the given data.
		 * @apiParam {String{..255}} device_token Must be string and unique.
		 * @apiParam {String} device_type Must be android or ios.
		 * @apiParam {Number} user_id User must exists.
		 * @apiParam {Boolean} active Boolean.
		 * @apiParamExample {json} Request-Example:
		 *     {
		 *       "device_token": "Token",
		 *       "device_type": "ios",
		 *       "user_id": 1,
		 *       "active": 1
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
		 * @apiName Devices/Save
		 * @apiGroup Push Notification
		 * @apiPermission Admin
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
		Route::post('save', 'PushNotificationsDevicesController@save');

		/**
		 * @api {post} /notifications/push_notifications_devices/deleted/:perPage/:sortBy/:desc?page=:pageNUmber Deleted
		 * @apiDescription Find deleted devices that match the given conditions in pages.
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
		 * @apiName Devices/Pagiante by
		 * @apiGroup Push Notification
		 * @apiPermission Admin
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
		 * @apiSuccess {Number} data.id Id of the device.
		 * @apiSuccess {String} data.device_token Token of the device.
		 * @apiSuccess {String} data.device_type Type of the device ('android', 'ios').
		 * @apiSuccess {String} data.active The device is active or not.
		 * @apiSuccess {String} data.user_id Id of the user that own the device.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /notifications/devices/deleted/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /notifications/devices/deleted/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "device_token": "Token",
		 *       "device_type": "android",
		 *       "user_id": 1,
		 *       "active": 1
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
		Route::post('deleted/{perPage?}/{sortBy?}/{desc?}', 'PushNotificationsDevicesController@deleted');
	});
});
