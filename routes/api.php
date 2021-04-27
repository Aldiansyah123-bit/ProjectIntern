<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'API\Auth\LoginController@login');
Route::post('/register', 'API\Auth\RegisterController@register');
Route::post('/forgot', 'API\Auth\ForgotController@forgot');
Route::post('/logout', 'API\Auth\LogoutController@logout');

//User
Route::get('/data-user', 'API\UserController@index');

//Region
Route::get('/regions', 'API\RegionController@index');

//BUMDES
Route::get('/bumdes', 'API\BumdesController@index');
Route::get('/bumdes/detail/{id}', 'API\BumdesController@detail');
Route::post('/bumdes/create', 'API\BumdesController@create');
Route::post('/bumdes/update/{id}', 'API\BumdesController@update');
Route::delete('/bumdes/delete/{id}', 'API\BumdesController@destroy');

//UMKM
Route::get('/umkm', 'API\UmkmController@index');
Route::get('/umkm/detail/{id}', 'API\UmkmController@detail');
Route::post('/umkm/create', 'API\UmkmController@create');
Route::post('/umkm/update/{id}', 'API\UmkmController@update');
Route::delete('/umkm/delete/{id}', 'API\UmkmController@destroy');

//Product
Route::get('/product', 'API\ProductController@index');
Route::get('/product/detail/{id}', 'API\ProductController@detail');
Route::get('/product/getproduct', 'API\ProductController@getProduct');
Route::post('/product/create', 'API\ProductController@create');
Route::post('/product/update/{id}', 'API\ProductController@update');
Route::delete('/product/delete/{id}', 'API\ProductController@destroy');

//Banner
Route::get('/banner', 'API\BannerController@index');
Route::post('/banner/create', 'API\BannerController@create');
Route::post('/banner/update/{id}', 'API\BannerController@update');
Route::delete('/banner/delete/{id}', 'API\BannerController@destroy');

//Cart
Route::get('/cart', 'API\CartController@index');
Route::post('/cart/create', 'API\CartController@create');
Route::get('/cart/show/{id}', 'API\CartController@show');
Route::post('/cart/update/{id}', 'API\CartController@update');
Route::delete('/cart/delete/{id}', 'API\CartController@destroy');
Route::get('/cart/getAddUs', 'API\CartController@getAddUser');
Route::get('/cart/getAddU', 'API\CartController@getAddUmkm');
Route::get('/cart/getAddB', 'API\CartController@getAddBumdes');

//Cartdetail
Route::get('/cartdetail', 'API\CartdetailController@index');
Route::post('/cartdetail/create', 'API\CartdetailController@create');
Route::get('/cartdetail/show/{id}', 'API\CartdetailController@show');
Route::post('/cartdetail/update/{id}', 'API\CartdetailController@update');
Route::delete('/cartdetail/delete/{id}', 'API\CartdetailController@destroy');
