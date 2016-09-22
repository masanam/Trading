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

    Route::get('contact/total', 'ContactController@getTotalContact');
    Route::resource('contact', 'ContactController', ['except' => [
        'index', 'create', 'edit'
    ]]);
    Route::get('contact/search/{search?}', 'ContactController@index');

    Route::get('buyer/total', 'BuyerController@getTotalBuyer');
    Route::resource('buyer', 'BuyerController', ['except' => [
        'index', 'create', 'edit'
    ]]);
    Route::get('buyer/search/{search?}', 'BuyerController@index');


    Route::get('seller/total', 'SellerController@getTotalSeller');
    Route::resource('seller', 'SellerController', ['except' => [
        'index', 'create', 'edit'
    ]]);
    Route::get('seller/search/{search?}', 'SellerController@index');

    Route::resource('buy_order', 'BuyOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('sell_order', 'SellOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('buy_sell_order', 'BuySellOrderController', ['only' => [
        'index'
    ]]);

    Route::resource('product', 'ProductController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('mine', 'MineController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('vendor/total', 'VendorController@getTotalVendor');
    Route::get('vendor/{search?}', 'VendorController@index');
    Route::resource('vendor', 'VendorController', ['except' => [
        'index', 'create', 'edit'
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

    Route::get('lead', 'LeadController@index');

    Route::get('news', 'NewsController@news');
    Route::get('news/refresh', 'NewsController@refreshNews');
});