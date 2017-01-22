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

Route::group(['prefix' => 'v1/reporting'], function() {
	
	Route::group(['prefix' => 'reports'], function() {
		
		/**
		 * @api {get} /acl/reports List
		 * @apiDescription List all reports.
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
		 * @apiName Reports
		 * @apiGroup Report
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Object[]} reports List of reports.
		 * @apiSuccess {Number} reports.id Id of the permission.
		 * @apiSuccess {String} reports.report_name Name of the report.
		 * @apiSuccess {String} reports.view_name View name of the report.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('/', 'ReportsController@index');

		/**
		 * @api {get} /acl/reports/find/:id Find
		 * @apiDescription Find report with the given id.
		 * @apiParam {Number} id Unique id of the report.
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
		 * @apiName Reports/Find
		 * @apiGroup Report
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Number} id Id of the permission.
		 * @apiSuccess {String} report_name Name of the report.
		 * @apiSuccess {String} view_name View name of the report.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::get('find/{id}', 'ReportsController@find');

		/**
		 * @api {get} /acl/reports/search/:query/:perPage/:sortBy/:desc?page=:pageNUmber Search
		 * @apiDescription Search reports with the given query.
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
		 * @apiName Reports/Search
		 * @apiGroup Report
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
		 * @apiSuccess {Number} data.id Id of the permission.
		 * @apiSuccess {String} data.report_name Name of the report.
		 * @apiSuccess {String} data.view_name View name of the report.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/reports/search/:query/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/reports/search/:query/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
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
		Route::get('search/{query?}/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@search');

		/**
		 * @api {get} /acl/reports/paginate/:perPage/:sortBy/:desc?page=:pageNUmber Paginate
		 * @apiDescription List all reports in pages.
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
		 * @apiName Reports/Paginate
		 * @apiGroup Report
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
		 * @apiSuccess {Number} data.id Id of the permission.
		 * @apiSuccess {String} data.report_name Name of the report.
		 * @apiSuccess {String} data.view_name View name of the report.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/reports/paginate/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/reports/paginate/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
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
		Route::get('paginate/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@paginate');

		/**
		 * @api {post} /acl/reports/first First
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
		 * @apiName Reports/First
		 * @apiGroup Report
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Number} id Id of the permission.
		 * @apiSuccess {String} report_name Name of the report.
		 * @apiSuccess {String} view_name View name of the report.
		 * @apiSuccessExample {object} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('first', 'ReportsController@first');

		/**
		 * @api {post} /acl/reports/findby/:sortBy/:desc Find by
		 * @apiDescription Find reports that match the given conditions.
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
		 * @apiName Reports/Find by
		 * @apiGroup Report
		 * @apiPermission Admin
		 *
		 * @apiSuccess {Object[]} reports List of reports.
		 * @apiSuccess {Number} reports.id Id of the permission.
		 * @apiSuccess {String} reports.report_name Name of the report.
		 * @apiSuccess {String} reports.view_name View name of the report.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     [
		 *     {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
		 *     }
		 *     ]
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 */
		Route::post('findby/{sortBy?}/{desc?}', 'ReportsController@findby');

		/**
		 * @api {post} /acl/reports/paginateby/:perPage/:sortBy/:desc?page=:pageNUmber Paginate by
		 * @apiDescription Find reports that match the given conditions in pages.
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
		 * @apiName Reports/Pagiante by
		 * @apiGroup Report
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
		 * @apiSuccess {Number} data.id Id of the permission.
		 * @apiSuccess {String} data.report_name Name of the report.
		 * @apiSuccess {String} data.view_name View name of the report.
		 * @apiSuccessExample {array} Success-Response:
		 *     HTTP/1.1 200 OK
		 *     {
		 *       "total": 100,
		 *       "per_page": 50,
		 *       "current_page": 1,
		 *       "last_page": 2,
		 *       "next_page_url": /acl/reports/paginateby/:perPage/:sortBy/:desc?page=2,
		 *       "prev_page_url": /acl/reports/paginateby/:perPage/:sortBy/:desc
		 *       "from": 1,
		 *       "to": 50,
		 *       "data": [
		 *       {
		 *       "id": 1,
		 *       "report_name": "admin_count",
		 *       "view_name": "admin_count"
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
		Route::post('paginateby/{perPage?}/{sortBy?}/{desc?}', 'ReportsController@paginateby');

		/**
		 * @api {post} /acl/reports/get/:reportName/:perPage Get
		 * @apiDescription Get the report data in the given report, data returned from this api depend on the data stored in the requested report.
		 * @apiParam {String} reportName Name of the report.
		 * @apiParam {Number} [perPage] Number of rows returned per page if not sent all data will be returned.
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
		 * @apiName Reports/Get
		 * @apiGroup Report
		 * @apiPermission Admin
		 *
		 * @apiSuccessExample {object} Admin count report:
		 *     HTTP/1.1 200 OK
		 *     {
		 *     	"count": 10
		 *     }
		 * 
		 * @apiError (Error 401) unAuthorized Authorization header token not sent.
		 * @apiError (Error 401) tokenExpired Authorization header token expired.
		 * @apiError (Error 403) noPermissions No permission to use this api.
		 * @apiError (Error 404) notFound The report with the given name not found.
		 */
		Route::post('get/{reportName}/{perPage?}', 'ReportsController@getReport');
	});
});
