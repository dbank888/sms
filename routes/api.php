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

//sms
Route::any('sms/dataList','ApiSmsController@dataList');

Route::any('receive','OpenApiController@receiveSms')->middleware('whiteList');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
