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

/* CHANGELOG
 *
 * hasapu 25-01-2017 added setting controller
 * kamal  21-03-2017 added costs routes for coalbizpedia
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
    Route::post('authenticate/forgot', 'AuthenticateController@forgotPassword');

    //roles & permission API
    Route::resource('role','RoleController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('permission','PermissionController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('privilege','PrivilegeController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('approval-scheme', 'OrderApprovalSchemeController', ['except' => [ 'create', 'edit' ]]);

    Route::resource('settings', 'SettingController', ['except' => ['create', 'edit']]);


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
});

Route::group(['middleware' => ['cors', 'throttle']], function() {
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
     * COALBIZPEDIA API GROUP
     */
    Route::resource('mining-license', 'MiningLicenseController', ['except' => ['create', 'edit']]);
    Route::match(['get','put'], 'mining-license/{id}/approval', 'MiningLicenseController@approval');
    Route::resource('spatial-data', 'SpatialDataController', ['except' => ['create', 'edit']]);
    Route::resource('productprice', 'ProductPriceController', ['except' => [ 'create', 'edit' ]]);

    Route::resource('metrics', 'QualityMetricController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('mining-license-file','MiningLicenseFileController', ['except' => ['create', 'edit']]);

    Route::resource('cost-detail', 'CostDetailController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('cost-header', 'CostHeaderController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('cost-total', 'CostTotalController', ['except' => [ 'create', 'edit' ]]);


    /*
     * SALES TARGET API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all sales target data
     */
    Route::get('sales-target/{year}/{month}', 'SalesTargetController@indexSalesTarget');
    Route::get('sales-target/{year}', 'SalesTargetController@index');
    Route::resource('sales-target', 'SalesTargetController', ['except' => [ 'create', 'edit' ]]);

    /*
     * PRODUCTION PLAN API GROUP - By Martin
     * this API contains ALL the things needed to manage
     * all production plan data
     */
    Route::get('production-plan/{year}', 'ProductionPlanController@index');
    Route::resource('production-plan', 'ProductionPlanController', ['except' => [ 'create', 'edit' ]]);

    /*
     * PRODUCT VARIAN API GROUP - By Martin
     * this API contains ALL the things needed to manage
     * all product varian data
     */

     Route::resource('product-variant', 'ProductVariantController', ['except' => [
         'create', 'edit'
     ]]);


    /*
     * QUALITIES API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all qualities
     */
    Route::resource('qualities', 'QualityController', ['except' => [ 'create', 'edit' ]]);

    Route::resource('quality-detail', 'QualityDetailController', ['except' => [ 'create', 'edit' ]]);

    /*
     * DOCUMENT API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all documents
     */
    Route::resource('document', 'DocumentController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('template', 'TemplateController', ['except' => [ 'create', 'edit' ]]);

    /*
     * CONSTANT SETTING API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all constant setting
     */
    Route::get('constant-setting', 'ConstantSettingController@index');
    Route::get('constant-setting/history', 'ConstantSettingController@findHistory');
    Route::get('constant-setting/{id}', 'ConstantSettingController@show');
    Route::post('constant-setting/add', 'ConstantSettingController@store');


    /*
     * OPERATIONAL PRICE SETTING API GROUP - By Myrtyl
     * this API contains ALL the things needed to manage
     * all operational price setting
     */
    Route::get('operational-price-setting', 'OperationalPriceSettingController@index');
    Route::get('operational-price-setting/history', 'OperationalPriceSettingController@findHistory');

    Route::post('operational-price-setting/update-price', 'OperationalPriceSettingController@updateInBulk');

    Route::get('operational-price-setting/{id}', 'OperationalPriceSettingController@show');


    /*
     * INDEX API GROUP
     * index management is the API that needed by
     * Index frontend or the Dashboards
     */
    Route::resource('index-price', 'IndexPriceController', ['except' => [
       'create', 'edit'
    ]]);
    Route::post('index/multiple-price', 'IndexController@price');
    Route::post('index/single-price', 'IndexController@singlePrice');
    Route::post('index/single-date', 'IndexController@storeSingleDate');

    Route::get('index/single-date', 'IndexController@singleDate');
    Route::get('index/{id}/price', 'IndexController@indexPrice');

    Route::resource('index', 'IndexController', ['except' => [
        'create', 'edit'
    ]]);


    /*
     * ORDER API GROUP
     * Managing orders (buy/sell) done here
     */
    Route::get('orders/print', 'OrderController@printPdf');

    Route::resource('leads', 'LeadController', ['except' => [ 'create', 'edit' ]]);
    Route::get('leads/{id}/test', 'LeadController@isSingleLeadInOrder');

    Route::put('orders/{id}/stage', 'OrderController@stage');
    Route::put('orders/{id}/unstage', 'OrderController@unstage');
    Route::match(['get','put'], 'orders/{id}/approval', 'OrderController@approval');
    Route::resource('orders', 'OrderController', ['except' => [ 'create', 'edit' ]]);

    /*
     * EXCHANGE RATE API GROUP
     */

    // Route::get('exchange-rate/update', 'ExchangeRateController@updateLatestExchangeRate');
    // Route::get('exchange-rate/{buy}/{sell}', 'ExchangeRateController@findOne');
    Route::resource('exchange-rate', 'ExchangeRateController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('currency', 'CurrencyController', ['except' => [ 'create', 'edit' ]]);


    /*
     * CONTRACT API GROUP
     */

    // Route::post('contracts/import', 'ContractController@importCsv');
    // Route::get('contracts/example', 'ContractController@getExample');
    Route::resource('contracts', 'ContractController', ['except' => [ 'create', 'edit' ]]);
    Route::get('contracts/{id}/calculations', 'ContractController@contractCalculations');

    /*
     * SHIPMENT API GROUP
     */

    // Route::post('shipments/status-log', 'ShipmentController@storeShipmentLog');
    Route::post('shipments/{id}/status-log', 'ShipmentController@storeShipmentLog');
    Route::get('shipments/{id}/status-log', 'ShipmentController@showShipmentLogByShipment');
    Route::get('shipments/product', 'ShipmentController@showShipmentProducts');
    Route::get('shipments/{id}/invoice', 'ShipmentController@showQualityInvoice');

    Route::resource('shipments', 'ShipmentController', ['except' => [ 'create', 'edit' ]]);
    Route::resource('shipping-instructions', 'ShippingInstructionController', ['except' => [ 'create', 'edit' ]]);

    Route::resource('shipment-plans', 'ShipmentPlanController', ['except' => [ 'create', 'edit' ]]);
    Route::post('shipment-plans/{id}/stage', 'ShipmentController@storeShipmentFromPlans');


    /*
     * VESSEL API
     */

    Route::resource('vessel', 'VesselController', ['except' => ['create', 'edit']]);

    /*
     * LOADER API
     */

    Route::resource('loader', 'LoaderController', ['except' => ['create', 'edit']]);

    /*
    * INVOICES API GROUP
    */

    Route::resource('invoices', 'InvoiceController', ['except' => [ 'index', 'store', 'create', 'edit' ]]);
    Route::put('invoices/{id}/tier', 'InvoiceController@tier');

});
