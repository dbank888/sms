<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Tool
Route::any('clearAllCache','ToolController@clearAllCache');

//sms
Route::post('sms/dataList','ApiSmsController@dataList');

//company
Route::post('company/dataList','ApiCompanyController@dataList');
Route::post('company/createConf','ApiCompanyController@createConf');
Route::post('company/store','ApiCompanyController@store');
Route::post('company/editInfo','ApiCompanyController@editInfo');
Route::post('company/update','ApiCompanyController@update');
Route::post('company/delete','ApiCompanyController@delete');

Route::any('receive','OpenApiController@receiveSms')->middleware('whiteList');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
