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
    Route::resource('company', 'CompanyController', ['except' => [ 'create', 'edit' ]]);

    Route::resource('contact', 'ContactController', ['except' => [ 'create', 'edit' ]]);
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

    Route::get('order/funnel','OrderController@funnel');

    Route::resource('leads', 'LeadController', ['except' => [ 'create', 'edit' ]]);
    Route::post('order/{id}/additional-cost', 'OrderController@createOrderAdditionalCost');
    Route::put('order/{id}/additional-cost', 'OrderController@updateOrderAdditionalCost');
    Route::put('order/{id}/stage', 'OrderController@stage');
    Route::put('order/{id}/approval', 'OrderController@approval');

    Route::put('orders/{id}/stage', 'OrderController@stage');
    Route::put('orders/{id}/unstage', 'OrderController@unstage');
    Route::match(['get','put'], 'orders/{id}/approval', 'OrderController@approval');
    Route::resource('orders', 'OrderController', ['except' => [ 'create', 'edit' ]]);

});
