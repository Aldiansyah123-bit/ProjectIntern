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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Bumdes
Route::get('/bumdes', 'WEB\BumdeseController@index');
Route::get('/bumdes/add', 'WEB\BumdeseController@show');
Route::get('/bumdes/detail/{id}', 'WEB\BumdeseController@detail');
Route::get('/bumdes/edit/{id}', 'WEB\BumdeseController@edit');
Route::post('/bumdes/update/{id}', 'WEB\BumdeseController@update');
Route::post('/bumdes/create', 'WEB\BumdeseController@create');
Route::get('/bumdes/delete/{id}', 'WEB\BumdeseController@destroy');

//Umkm
Route::get('/umkm', 'WEB\UmkmController@index');
Route::get('/umkm/add', 'WEB\UmkmController@show');
Route::get('/umkm/detail/{id}', 'WEB\UmkmController@detail');
Route::get('/umkm/edit/{id}', 'WEB\UmkmController@edit');
Route::post('/umkm/update/{id}', 'WEB\UmkmController@update');
Route::post('/umkm/create', 'WEB\UmkmController@create');
Route::get('/umkm/delete/{id}', 'WEB\UmkmController@destroy');

//Product
Route::get('/product', 'WEB\ProductController@index');
Route::get('/product/add', 'WEB\ProductController@show');
Route::get('/product/detail/{id}', 'WEB\ProductController@detail');
Route::get('/product/edit/{id}', 'WEB\ProductController@edit');
Route::post('/product/update/{id}', 'WEB\ProductController@update');
Route::post('/product/create', 'WEB\ProductController@create');
Route::get('/product/delete/{id}', 'WEB\ProductController@destroy');
Route::post('/product/getproduct', 'WEB\ProductController@getProduct')->name('product.getProduct');

//Region
Route::post('region/getregion', 'WEB\RedionController@getRegion')->name('region.getRegion');
