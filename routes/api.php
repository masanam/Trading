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

    Route::post('signing', 'AuthenticateController@upload');

    Route::get('index', 'IndexController@index');
    Route::post('index/price', 'IndexController@price');
    Route::post('index/single-price', 'IndexController@singlePrice');

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

    Route::get('buyer/total', 'BuyerController@getTotalBuyer');
    Route::get('buyer/search/{search?}', 'BuyerController@search');
    Route::resource('buyer', 'BuyerController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('seller/total', 'SellerController@getTotalSeller');
    Route::get('seller/search/{search?}', 'SellerController@search');
    Route::resource('seller', 'SellerController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('order/buy', 'BuyOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('order/buy/status/{order_status}/{progress_status?}', 'BuyOrderController@status', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('order/buy/{id}/changeOrderStatus/{order_status}', 'BuyOrderController@changeOrderStatus', ['except' => [
        'create', 'edit'
    ]]);


    Route::resource('order/sell', 'SellOrderController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('order/sell/status/{order_status}/{progress_status?}', 'SellOrderController@status', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('order/sell/{id}/changeOrderStatus/{order_status}', 'SellOrderController@changeOrderStatus', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('order/lastOrder/{type}/{id}', 'BuySellOrderController@lastOrderByUser');
    Route::get('order/lastOrders/{type}/{id}', 'BuySellOrderController@lastOrderForDetail');
    //Route::get('order/{user_id}', 'BuySellOrderController@orderDealByUser');
    Route::resource('order', 'BuySellOrderController', ['only' => [
        'index'
    ]]);

    Route::get('product/total', 'ProductController@getTotalProduct');
    Route::get('product/search/{search?}', 'ProductController@search');
    Route::resource('product', 'ProductController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('concession/total', 'ConcessionController@getTotalConcession');
    Route::get('concession/search/{search?}', 'ConcessionController@search');
    Route::get('concession/filter', 'ConcessionController@filter');
    Route::get('concession/detail/{id}', 'ConcessionController@detail');
    Route::resource('concession', 'ConcessionController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('vendor/total', 'VendorController@getTotalVendor');
    Route::get('vendor/search/{search?}', 'VendorController@search');
    Route::resource('vendor', 'VendorController', ['except' => [
        'create', 'edit'
    ]]);

    Route::get('buy-deal/chat/{buy_deal}', 'BuyDealChatController@showAllBuyDealChatsByOrderDeal');
    Route::post('buy-deal/chat/send', 'BuyDealChatController@sendChat');
    Route::delete('buy-deal/{dealId}', 'BuyDealController@destroyByDeal');
    Route::get('buy-deal/getByDeal/{dealId}', 'BuyDealController@getByDeal');
    Route::get('buy-deal/getOneByDealAndOrder/{buyOrder}/{dealId}', 'BuyDealController@getOneByDealAndOrder');
    Route::get('buy-deal/{buy_deal}/{approval}', 'BuyDealController@approval');
    Route::resource('buy-deal', 'BuyDealController', ['except' => [
        'create', 'edit'
    ]]);
    
    Route::get('sell-deal/chat/{sell_deal}', 'SellDealChatController@showAllSellDealChatsByOrderDeal');
    Route::post('sell-deal/chat/send', 'SellDealChatController@sendChat');
    Route::delete('sell-deal/{dealId}', 'SellDealController@destroyByDeal');
    Route::get('sell-deal/getByDeal/{dealId}', 'SellDealController@getByDeal');
    Route::get('sell-deal/getOneByDealAndOrder/{sellOrder}/{dealId}', 'SellDealController@getOneByDealAndOrder');
    Route::get('sell-deal/{sell_deal}/{approval}', 'SellDealController@approval');
    Route::resource('sell-deal', 'SellDealController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('order-deal', 'BuySellDealController@index');
    Route::resource('order-deal/user/{user_id}', 'BuySellDealController@orderDealByUser');
    
    Route::get('deal/table/{status}', 'DealController@index');
    Route::get('deal/status/{deal}/{status}', 'DealController@changeStatus');
    Route::resource('deal', 'DealController', ['except' => [
        'index', 'create', 'edit', 'destroy'
    ]]);
});