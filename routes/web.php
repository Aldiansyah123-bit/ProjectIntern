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

//banner
Route::get('/banner', 'WEB\BannerController@index');
Route::get('/banner/add', 'WEB\BannerController@show');
Route::get('/banner/edit/{id}', 'WEB\BannerController@edit');
Route::post('/banner/update/{id}', 'WEB\BannerController@update');
Route::post('/banner/create', 'WEB\BannerController@create');
Route::get('/banner/delete/{id}', 'WEB\BannerController@destroy');

//Cart
Route::get('/cart', 'WEB\CartController@index');
Route::get('/cart/add', 'WEB\CartController@show');
Route::get('/cart/detail/{id}', 'WEB\CartController@detail');
Route::get('/cart/getAddUs', 'WEB\CartController@getAddUser')->name('cart.getAddUser');
Route::get('/cart/getAddU', 'WEB\CartController@getAddUmkm')->name('cart.getAddUmkm');
Route::get('/cart/getAddB', 'WEB\CartController@getAddBumdes')->name('cart.getAddBumdes');
Route::post('/cart/create', 'WEB\CartController@create');
Route::get('/cart/edit/{id}', 'WEB\CartController@edit');
Route::post('/cart/update/{id}', 'WEB\CartController@update');
Route::get('/cart/delete/{id}', 'WEB\CartController@destroy');

//Transaction
Route::get('/transaction', 'WEB\TransactionController@index');
Route::get('/transaction/add', 'WEB\TransactionController@show');
Route::get('/transaction/detail/{id}', 'WEB\TransactionController@detail');
Route::get('/transaction/getAddUs', 'WEB\TransactionController@getAddUser')->name('transaction.getAddUser');
Route::get('/transaction/getAddU', 'WEB\TransactionController@getAddUmkm')->name('transaction.getAddUmkm');
Route::get('/transaction/getAddB', 'WEB\TransactionController@getAddBumdes')->name('transaction.getAddBumdes');
Route::post('/transaction/create', 'WEB\TransactionController@create');
Route::get('/transaction/edit/{id}', 'WEB\TransactionController@edit');
Route::post('/transaction/update/{id}', 'WEB\TransactionController@update');
Route::get('/transaction/delete/{id}', 'WEB\TransactionController@destroy');

//Transaction Detail
Route::get('/transdel', 'WEB\TransactiondetailController@index');
Route::get('/transdel/add', 'WEB\TransactiondetailController@store');
Route::get('/transdel/detail/{id}', 'WEB\TransactiondetailController@show');
Route::get('/transdel/getTransaction', 'WEB\TransactiondetailController@getTransaction')->name('transdel.getTransaction');
Route::get('/transdel/getProduct', 'WEB\TransactiondetailController@getProduct')->name('transdel.getProduct');
Route::post('/transdel/create', 'WEB\TransactiondetailController@create');
Route::get('/transdel/edit/{id}', 'WEB\TransactiondetailController@edit');
Route::post('/transdel/update/{id}', 'WEB\TransactiondetailController@update');
Route::get('/transdel/delete/{id}', 'WEB\TransactiondetailController@destroy');

//Region
Route::get('region/getregion', 'WEB\RegionController@getRegion')->name('region.getRegion');
