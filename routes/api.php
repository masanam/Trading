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
    Route::get('coalpedia/total', 'CoalpediaController@count');

    Route::get('company/{id}/attach', 'CompanyController@attach'); //port, concession, factory, product
    Route::get('company/{id}/detach', 'CompanyController@detach'); //port, concession, factory, product

    Route::resource('contact', 'ContactController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('company', 'CompanyController', ['except' => [ 'create', 'edit' ]]);

    Route::resource('port', 'PortController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('product', 'ProductController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('concession', 'ConcessionController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('factory', 'FactoryController', ['except' => [ 'create', 'edit' ]]);

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
    //Route::get('order/{order}/user', 'OrderUserController@findUserByOrder');
    // Route::get('order/user/{user}', 'OrderUserController@findOrderByUser');
    // Route::get('order/buy/status/{order_status}/{progress_status?}', 'BuyOrderController@status');
    // Route::get('order/buy/draft/{user_id}', 'BuyOrderController@draft');
    // Route::get('order/buy/getSub', 'BuyOrderController@getSub');
    // Route::get('order/buy/getManager', 'BuyOrderController@getManager');
    Route::get('order/buy/{id}/changeOrderStatus/{order_status}', 'BuyOrderController@changeOrderStatus');

    // Route::get('order/sell/status/{order_status}/{progress_status?}', 'SellOrderController@status', ['except' => [ 'create', 'edit' ]]);
    // Route::get('order/sell/draft/{user_id}', 'SellOrderController@draft', ['except' => [ 'create', 'edit' ]]);
    Route::get('order/sell/{id}/changeOrderStatus/{order_status}', 'SellOrderController@changeOrderStatus', ['except' => [ 'create', 'edit' ]]);

    // Route::get('order/lastOrder/{type}/{id}', 'BuySellOrderController@lastOrderByUser');
    // Route::get('order/lastOrders/{type}/{id}', 'BuySellOrderController@lastOrderForDetail');


    Route::resource('order/sell', 'SellOrderController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('order/buy', 'BuyOrderController', ['except' => [ 'create', 'edit' ]]);

    //DUmmy api, just for show
    // Route::get('order/{id}/approve-now', 'OrderController@approveNow');
    // Route::get('order/{id}/reject-now', 'OrderController@rejectNow');

    /*
     * DEAL API GROUP
     * Managing the deals (buy/sell) done here
     */
    // Route::get('order/ordersum','OrderController@ordersum');
    Route::get('order/funnel','OrderController@funnel');
    // Route::get('order/{id}/test-mail', 'OrderController@testMail');
    Route::post('order/{id}/stage', 'OrderController@stage');
    Route::get('order/{id}/stage', 'OrderController@stageOwn');
    Route::get('order/{id}/unstage', 'OrderController@unstage');
    Route::get('order/{id}/approve', 'OrderController@approve');
    Route::resource('order', 'OrderController');
});
