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

Route::get('/', 'MainController@index');

Auth::routes();
Route::get('/branches', 'MainController@branches')->name('main_branches');
Route::get('/styles', 'MainController@styles')->name('main_styles');
Route::get('/prices', 'MainController@prices')->name('main_prices');
Route::get('/teachers', 'MainController@teachers')->name('main_teachers');

Route::group(['middleware' => ['checkRole:1a']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('branch', 'BranchController');
    Route::resource('notice', 'NoticeController');
    Route::resource('group', 'GroupController');
    Route::resource('teacher', 'TeacherController');
    Route::resource('customer', 'CustomerController');
    Route::resource('style', 'StyleController');
    Route::resource('price', 'PriceController');
    Route::resource('news', 'NewsController');
});

Route::group(['middleware' => ['checkRole:1a,3c']], function () {
    Route::get('/learner', 'HomeController@learner')->name('learner');
    Route::resource('customer', 'CustomerController')->only([
        'show', 'edit', 'update'
    ]);
});

Route::group(['middleware' => ['checkRole:1a,2t']], function () {
    Route::get('/master', 'HomeController@master')->name('master');
    Route::resource('teacher', 'TeacherController')->only([
        'show', 'edit', 'update'
    ]);
    Route::resource('notice', 'NoticeController');
});

Route::group(['middleware' => ['checkRole:1a,3c,2t']], function () {
    Route::resource('group', 'GroupController')->only([
        'index', 'show'
    ]);
});
Route::group(['middleware' => ['checkRole:1a,guest']], function () {
    Route::resource('customer', 'CustomerController')->only([
        'store'
    ]);
});

