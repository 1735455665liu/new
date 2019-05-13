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

Route::get('/', function () {
    return view('welcome');
});
Route::get('getenctype','Test\TestController@getencrypt');
Route::get('ksen','Test\TestController@ksen');
Route::get('ksdn','Test\TestController@ksdn');
Route::get('test','Test\TestController@test');
Route::get('nocrypt','Test\TestController@nocrypt');
Route::get('nosign','Test\TestController@nosign');
Route::get('reg','Test\TestController@reg');
Route::get('login','Test\TestController@login');