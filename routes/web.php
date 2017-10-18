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
Auth::routes();

Route::get('/', 'HomeController@home')->name('home');

Route::get('/spend', 'HomeController@index')->name('home');

Route::get('/spend/store', 'SpendController@index')->name('get_store');

Route::post('/spend/store', 'SpendController@store')->name('post_store');

Route::get('/user-children', 'ParentsController@index');
