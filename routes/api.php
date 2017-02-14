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


Route::group(['middleware' => ['cors', 'throttle']], function() {
    /*
     * USER API GROUP
     * this API contains ALL the things needed by coalpedia to manage
     * all their data: contact, buyer, seller, vendor
     */
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::post('authenticate/signup', 'AuthenticateController@signup');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
    Route::post('authenticate/forgot', 'AuthenticateController@forgotPassword');


    //S3 Upload file signing API
    Route::post('signing', 'AuthenticateController@signing');

    //User Management API
    //Forgot Password API
    Route::post('user/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('user/current', 'UserController@currentUser');
    Route::put('user/{id}/restore', 'UserController@restore');
    Route::put('user/{id}/approve', 'UserController@approveUser');
    // Route::put('user/{id}/role', 'UserController@addRoleUser');
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

    Route::resource('area', 'AreaController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('country', 'CountryController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('contact', 'ContactController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('port', 'PortController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('product', 'ProductController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('concession', 'ConcessionController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('factory', 'FactoryController', ['except' => [ 'create', 'edit' ]]);

    /*
     * SALES TARGET API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all sales target data
     */
    Route::get('sales-target/{year}', 'SalesTargetController@index');
    Route::resource('sales-target', 'SalesTargetController', ['except' => [ 'create', 'edit' ]]);
    /*
     * QUALITIES API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all qualities
     */
    Route::resource('qualities', 'QualityController', ['except' => [ 'create', 'edit' ]]);

    /*
     * DOCUMENT API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all documents
     */
    Route::resource('documents', 'DocumentController', ['except' => [ 'create', 'edit' ]]);
    Route::get('templates', 'TemplateController@index');

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
    Route::put('orders/{id}/stage', 'OrderController@stage');
    Route::put('orders/{id}/unstage', 'OrderController@unstage');
    Route::match(['get','put'], 'orders/{id}/approval', 'OrderController@approval');
    Route::resource('orders', 'OrderController', ['except' => [ 'create', 'edit' ]]);

    Route::get('exchange-rate/{buy}/{sell}/history', 'ExchangeRateController@findHistory');
    Route::resource('exchange-rate', 'ExchangeRateController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('currency', 'CurrencyController', ['except' => [ 'create', 'edit' ]]);

    Route::get('leads/{id}/test', 'LeadController@isSingleLeadInOrder');

    Route::post('shipments/status-log', 'ShipmentController@storeShipmentLog');
    Route::get('shipments/status-log', 'ShipmentController@indexShipmentLog');
    Route::get('shipments/{id}/status-log', 'ShipmentController@showShipmentLogByShipment');
    Route::get('shipments/history', 'ShipmentController@indexShipmentHistory');
    Route::get('shipments/{id}/history', 'ShipmentController@showShipmentHistoryByShipment');
    Route::resource('contracts', 'ContractController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('shipments', 'ShipmentController', ['except' => [ 'create', 'edit' ]]);

    //roles & permission API
    Route::resource('role','RoleController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('permission','PermissionController', ['except' => [ 'create', 'edit' ]]);

    /*
     * IUP
     * By AndezTea
     */
    Route::resource('mining-license', 'MiningLicenseController', ['except' => ['create', 'edit']]);
    Route::match(['get','put'], 'mining-license/{id}/approval', 'MiningLicenseController@approval');
    Route::resource('spatial-data', 'SpatialDataController', ['except' => ['create', 'edit']]);

    //hasapu 25-01-2017
    Route::resource('metrics', 'QualityMetricController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('mining-license-file','MiningLicenseFileController', ['except' => ['create', 'edit']]);


});
