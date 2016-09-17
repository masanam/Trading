<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['cors']], function() {
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::post('authenticate/signup', 'AuthenticateController@signup');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

	Route::resource('user', 'UserController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('contact/{name}', 'ContactController@getContactByName');
    Route::resource('contact', 'ContactController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('buyer/{name}', 'BuyerController@getBuyerByName');
    Route::resource('buyer', 'BuyerController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('seller/{name}', 'SellerController@getSellerByName');
    Route::resource('seller', 'SellerController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('buy_order', 'BuyOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('sell_order', 'SellOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('product', 'ProductController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('mine', 'MineController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('vendor/{name}', 'VendorController@getVendorByName');
    Route::resource('vendor', 'VendorController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('buy_deal', 'BuyDealController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('sell_deal', 'SellDealController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('buy_sell_deal', 'BuySellDealController', ['only' => [
        'index'
    ]]);

    Route::resource('deal', 'DealController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('news', 'NewsController@news');
    Route::get('news/refresh', 'NewsController@refreshNews');
});