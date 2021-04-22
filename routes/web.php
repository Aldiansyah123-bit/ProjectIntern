<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    dd("storage");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Bumdes
Route::get('/bumdes', 'WEB\BumdeseController@index');
Route::get('/bumdes/add', 'WEB\BumdeseController@show');
Route::post('/bumdes/create', 'WEB\BumdeseController@create');
Route::get('/bumdes/delete/{id}', 'WEB\BumdeseController@destroy');

//Umkm
Route::get('/umkm', 'WEB\UmkmController@index');
Route::get('/umkm/add', 'WEB\UmkmController@show');
Route::post('/umkm/create', 'WEB\UmkmController@create');
Route::get('/umkm/delete/{id}', 'WEB\UmkmController@destroy');

