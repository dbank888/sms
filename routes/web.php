<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('company','CompanyController');
Route::resource('service','ServiceProviderController');

Route::get('smsList','PageController@smsList');

//调试路由
Route::resource('debug','DebugController');

//Excel 导入导出
Route::get('init/import','DataInitializationController@import');
Route::get('excel/import','ExcelController@import');

Route::get('clearAllCache','CacheController@clearAllCache');

Route::get('/', function () {
    return view('home');
})->middleware('whiteList');


