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
    Route::get('port/buyer/attachPort/{buyer_id}/{port_id}', 'PortController@attachBuyerPort');
    Route::get('port/buyer/detachPort/{buyer_id}/{port_id}', 'PortController@detachBuyerPort');
    Route::get('port/seller/attachPort/{seller_id}/{port_id}', 'PortController@attachSellerPort');
    Route::get('port/seller/detachPort/{seller_id}/{port_id}', 'PortController@detachSellerPort');
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
    Route::post('index/multiple-price', 'IndexController@price');
    Route::post('index/single-price', 'IndexController@singlePrice');
    Route::post('index/single-date', 'IndexController@storeSingleDate');

    Route::get('index/single-date', 'IndexController@singleDate');
    Route::get('index/{id}/price', 'IndexController@indexPrice');

    Route::resource('index', 'IndexController', ['except' => [
        'create', 'edit'
    ]]);
    Route::resource('index/price', 'IndexPriceController', ['except' => [
        'create', 'edit'
    ]]);


    /* 
     * ORDER API GROUP
     * Managing orders (buy/sell) done here
     */
    Route::get('order/{order}/user', 'OrderUserController@findUserByOrder');
    Route::get('order/user/{user}', 'OrderUserController@findOrderByUser');
    Route::get('order/buy/status/{order_status}/{progress_status?}', 'BuyOrderController@status');
    Route::get('order/buy/draft/{user_id}', 'BuyOrderController@draft');
    Route::get('order/buy/getSub', 'BuyOrderController@getSub');
    Route::get('order/buy/getManager', 'BuyOrderController@getManager');
    Route::get('order/buy/{id}/changeOrderStatus/{order_status}', 'BuyOrderController@changeOrderStatus');

    Route::get('order/sell/status/{order_status}/{progress_status?}', 'SellOrderController@status', ['except' => [ 'create', 'edit' ]]);
    Route::get('order/sell/draft/{user_id}', 'BuyOrderController@draft', ['except' => [ 'create', 'edit' ]]);
    Route::get('order/sell/{id}/changeOrderStatus/{order_status}', 'SellOrderController@changeOrderStatus', ['except' => [ 'create', 'edit' ]]);

    Route::get('order/lastOrder/{type}/{id}', 'BuySellOrderController@lastOrderByUser');
    Route::get('order/lastOrders/{type}/{id}', 'BuySellOrderController@lastOrderForDetail');

    Route::resource('order/sell', 'SellOrderController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('order/buy', 'BuyOrderController', ['except' => [ 'create', 'edit' ]]);


    /* 
     * DEAL API GROUP
     * Managing the deals (buy/sell) done here
     */
    
    Route::resource('order', 'OrderController');
});