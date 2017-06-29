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

//Excel 导入导出
Route::get('init/import','DataInitializationController@import');
Route::get('excel/import','ExcelController@import');

Route::get('clearAllCache','CacheController@clearAllCache');

//auth
Route::post('auth/login','Auth\LoginController@doLogin')->middleware('web');

/**page**/
Route::group(['middleware' => 'auth'],function(){
    Route::get('home', function () {
        return view('index.index');
    })->name('home');

    Route::get('index', function () {
        return view('page.home');
    });

    Route::get('calendar', function () {
        return view('page.calendar');
    });

    Route::resource('company','CompanyController');
    Route::resource('service','ServiceProviderController');
    Route::get('smsList','PageController@smsList');

    //laravel
    Route::get('laravel', function () {
        return view('page.welcome');
    });
});

Route::get('/', function () {
    return redirect()->intended('home');
});

Auth::routes();

