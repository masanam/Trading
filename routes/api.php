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
    /* 
     * USER API GROUP
     * this API contains ALL the things needed by coalpedia to manage
     * all their data: contact, buyer, seller, vendor
     */
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::post('authenticate/signup', 'AuthenticateController@signup');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

    //S3 Upload file signing API
    Route::post('signing', 'AuthenticateController@signing');

    //Coal Index Price API
    /*Route::post('index/price', 'IndexController@price');
    Route::post('index/single-price', 'IndexController@singlePrice');
    Route::get('index/single-date', 'IndexController@singleDate');
    Route::get('index/{id}/price', 'IndexController@indexPrice');
    Route::resource('index', 'IndexController');*/

    //User Management API
    //Forgot Password API
    Route::post('user/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('user/current', 'UserController@currentUser');
    Route::resource('user', 'UserController', ['except' => [ 'create', 'edit' ]]);

    /* 
     * COALPEDIA API GROUP
     * this API contains ALL the things needed by coalpedia to manage
     * all their data: contact, buyer, seller, vendor
     */
    Route::get('buyer/total', 'BuyerController@getTotalBuyer');
    Route::get('seller/total', 'SellerController@getTotalSeller');

    Route::resource('contact', 'ContactController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('buyer', 'BuyerController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('seller', 'SellerController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('vendor', 'VendorController', ['except' => [ 'create', 'edit' ]]);

    //Port Management API
    Route::post('port/buyer/store', 'PortController@storeBuyerPort');
    Route::post('port/seller/store', 'PortController@storeSellerPort');
    Route::get('port/buyer/allMy/{buyer_id}', 'PortController@buyerAllMyPort');
    Route::get('port/seller/allMy/{seller_id}', 'PortController@sellerAllMyPort');
    Route::get('port/buyer/my/{buyer_id}', 'PortController@buyerMyPort');
    Route::get('port/seller/my/{seller_id}', 'PortController@sellerMyPort');
    Route::get('port/buyer/status/{buyer_id}/{port_id}/{status}', 'PortController@changePortStatusBuyer');
    Route::get('port/seller/status/{seller_id}/{port_id}/{status}', 'PortController@changePortStatusSeller');
    Route::get('port/{id}/concession', 'PortController@connectedConcessions');
    Route::resource('port', 'PortController', ['except' => [ 'create', 'edit' ]]);

    //Product Management API
    Route::get('product/{id}/my/buyer', 'ProductController@findMyProductBuyer');
    Route::get('product/{id}/my/seller', 'ProductController@findMyProductSeller');
    Route::get('product/total', 'ProductController@getTotalProduct');
    Route::get('product/search/{search?}', 'ProductController@search');
    Route::delete('product/{id}', 'ProductController@destroyByID');
    Route::resource('product', 'ProductController', ['except' => [ 'create', 'edit' ]]);

    //Concession Management API
    Route::get('concession/total', 'ConcessionController@getTotalConcession');
    Route::get('concession/filter', 'ConcessionController@filter');
    Route::get('concession/my/{id}', 'ConcessionController@findMyConcession');
    Route::get('concession/detail/{id}', 'ConcessionController@detail');
    Route::resource('concession', 'ConcessionController', ['except' => [ 'create', 'edit' ]]);

    //Factory Management API
    Route::get('factory/my/{id}', 'FactoryController@findMyFactory');
    Route::resource('factory', 'FactoryController', ['except' => [
        'create', 'edit'
    ]]);


    /* 
     * INDEX API GROUP
     * index management is the API that needed by
     * Index frontend or the Dashboards
     */
    Route::post('index/price', 'IndexController@price');
    Route::post('index/single-price', 'IndexController@singlePrice');
    Route::post('index/single-date', 'IndexController@storeSingleDate');

    Route::get('index/single-date', 'IndexController@singleDate');
    Route::get('index/{id}/price', 'IndexController@indexPrice');

    Route::resource('index', 'IndexController', ['except' => [
        'create', 'edit'
    ]]);
    /*Route::resource('index/price', 'IndexPriceController', ['except' => [
        'create', 'edit'
    ]]);*/


    /* 
     * ORDER API GROUP
     * Managing orders (buy/sell) done here
     */
    Route::get('order/buy/status/{order_status}/{progress_status?}', 'BuyOrderController@status', ['except' => [ 'create', 'edit' ]]);
    Route::get('order/buy/{id}/changeOrderStatus/{order_status}', 'BuyOrderController@changeOrderStatus', ['except' => [ 'create', 'edit' ]]);

    Route::get('order/sell/status/{order_status}/{progress_status?}', 'SellOrderController@status', ['except' => [ 'create', 'edit' ]]);
    Route::get('order/sell/{id}/changeOrderStatus/{order_status}', 'SellOrderController@changeOrderStatus', ['except' => [ 'create', 'edit' ]]);

    Route::get('order/lastOrder/{type}/{id}', 'BuySellOrderController@lastOrderByUser');
    Route::get('order/lastOrders/{type}/{id}', 'BuySellOrderController@lastOrderForDetail');

    Route::resource('order/sell', 'SellOrderController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('order/buy', 'BuyOrderController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('order', 'BuySellOrderController', ['only' => [ 'index' ]]);


    /* 
     * DEAL API GROUP
     * Managing the deals (buy/sell) done here
     */
    Route::get('deal/table/{status}', 'DealController@index');
    Route::get('deal/status/{deal}/{status}', 'DealController@changeStatus');
    Route::get('deal/user/{user}', 'DealController@findByUser');

    Route::delete('buy-deal/{dealId}', 'BuyDealController@destroyByDeal');
    Route::get('buy-deal/getByDeal/{dealId}', 'BuyDealController@getByDeal');
    Route::get('buy-deal/getOneByDealAndOrder/{buyOrder}/{dealId}', 'BuyDealController@getOneByDealAndOrder');
    Route::get('buy-deal/{buy_deal}/{approval}', 'BuyDealController@approval');

    Route::delete('sell-deal/{dealId}', 'SellDealController@destroyByDeal');
    Route::get('sell-deal/getByDeal/{dealId}', 'SellDealController@getByDeal');
    Route::get('sell-deal/getOneByDealAndOrder/{sellOrder}/{dealId}', 'SellDealController@getOneByDealAndOrder');
    Route::get('sell-deal/{sell_deal}/{approval}', 'SellDealController@approval');

    Route::get('order-deal/user/{user_id}', 'BuySellDealController@orderDealByUser');

    Route::resource('deal', 'DealController', ['except' => [ 'index', 'create', 'edit', 'destroy' ]]);
    Route::resource('buy-deal', 'BuyDealController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('sell-deal', 'SellDealController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('order-deal', 'BuySellDealController@index');
});