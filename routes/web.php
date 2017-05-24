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

//调试路由
Route::resource('debug','DebugController');

Route::get('init/import','DataInitializationController@import');
Route::get('excel/import','ExcelController@import');

Route::get('smsList','PageController@smsList');


Route::get('/', function () {
    return view('welcome');
})->middleware('whiteList');


