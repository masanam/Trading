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

    Route::get('user/current', 'UserController@currentUser');
    Route::resource('user', 'UserController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('contact/total', 'ContactController@getTotalContact');
    Route::get('contact/search/{search?}', 'ContactController@search');
    Route::delete('contact/{id}', 'ContactController@destroy');
    Route::resource('contact', 'ContactController', ['except' => [
        'create', 'edit'
    ]]);
    // Route::get('contact/search/{search?}', 'ContactController@index');

    Route::get('buyer/total', 'BuyerController@getTotalBuyer');
    Route::resource('buyer', 'BuyerController', ['except' => [
        'create', 'edit'
    ]]);
    // Route::get('buyer/search/{search?}', 'BuyerController@index');

    Route::get('seller/total', 'SellerController@getTotalSeller');
    Route::get('seller/search/{search?}', 'SellerController@search');
    Route::resource('seller', 'SellerController', ['except' => [
        'create', 'edit'
    ]]);
    // Route::get('seller/search/{search?}', 'SellerController@index');

    Route::resource('buy_order', 'BuyOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('sell_order', 'SellOrderController', ['except' => [
        'create', 'edit'
    ]]);
    
    //Route::get('buy_sell_order/lastOrder/{buyerId?}', 'BuySellOrderController@search');
    Route::resource('buy_sell_order', 'BuySellOrderController', ['only' => [
        'index'
    ]]);

    Route::get('product/total', 'ProductController@getTotalProduct');
    Route::get('product/search/{search?}', 'ProductController@search');
    Route::resource('product', 'ProductController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('mine/total', 'MineController@getTotalMine');
    Route::get('mine/search/{search?}', 'MineController@search');
    Route::resource('mine', 'MineController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('vendor/total', 'VendorController@getTotalVendor');
    Route::get('vendor/search/{search?}', 'VendorController@search');
    Route::resource('vendor', 'VendorController', ['except' => [
        'create', 'edit'
    ]]);
    
    Route::delete('buy_deal/{dealId}', 'BuyDealController@destroyByDeal');
    Route::get('buy_deal/getByDeal/{dealId?}', 'BuyDealController@getByDeal');
    Route::resource('buy_deal', 'BuyDealController', ['except' => [
        'create', 'edit'
    ]]);
    
    Route::delete('sell_deal/{dealId}', 'SellDealController@destroyByDeal');
    Route::get('sell_deal/getByDeal/{dealId?}', 'SellDealController@getByDeal');
    Route::resource('sell_deal', 'SellDealController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('buy_sell_deal', 'BuySellDealController', ['only' => [
        'index'
    ]]);
    
    Route::get('deal/table/{status}', 'DealController@index');
    Route::get('deal/status/{deal}/{status}', 'DealController@changeStatus');
    Route::resource('deal', 'DealController', ['except' => [
        'create', 'edit', 'destroy'
    ]]);

    Route::get('chat/{user}', 'ChatController@index');
    Route::get('chat/{buy_order}', 'ChatController@show');
    Route::get('chat/message/{chat}/{user}', 'MessageController@index');

    Route::get('lead/{search?}', 'LeadController@index');

    Route::get('news', 'NewsController@news');
    Route::get('news/refresh', 'NewsController@refreshNews');
});