'use strict';

// Setting up route
angular.module('lead').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('lead', {
        url: '/lead',
        abstract: true,
        template: '<ui-view/>'
      })
      .state('lead.index', {
        url: '',
        templateUrl: '/angular/lead/views/index.view.html',
        roles: ['user', 'trader', 'manager']
      })

      //buy lead
      .state('lead.buy', {
        url: '/buy',
        abstract: true,
        template: '<ui-view/>'
      })
      .state('lead.buy.index', {
        url: '',
        templateUrl: '/angular/lead/views/buy/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.buy.create', {
        url: '/create',
        templateUrl: '/angular/order/views/sell-order/step.supplier.view.html'
      })
      .state('lead.buy.step-supplier', {
        url: '/create/supplier/:order_id',
        templateUrl: '/angular/order/views/sell-order/step.supplier.view.html'
      })
      .state('lead.buy.step-concession', {
        url: '/create/concession/:id/:order_id',
        templateUrl: '/angular/order/views/sell-order/step.concession.view.html'
      })
      .state('lead.buy.step-product', {
        url: '/create/product/:id/:order_id/:concession_id',
        templateUrl: '/angular/order/views/sell-order/step.product.view.html'
      })
      .state('lead.buy.step-port', {
        url: '/create/port/:id/:order_id/:concession_id',
        templateUrl: '/angular/order/views/sell-order/step.port.view.html'
      })
      .state('lead.buy.step-summary', {
        url: '/create/summary/:id/:order_id/:concession_id',
        templateUrl: '/angular/order/views/sell-order/step.summary.view.html'
      })
      .state('lead.buy.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/sell-order/view.view.html'
      })
      .state('lead.buy.update', {
        url: '/update/:id',
        templateUrl: '/angular/order/views/sell-order/update.view.html'
      })

      //browse page
      .state('lead.buyer', {
        url: '/buyer?keyword',
        templateUrl: '/angular/lead/views/buyer/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.seller', {
        url: '/seller?keyword',
        templateUrl: '/angular/lead/views/seller/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.vendor', {
        url: '/vendor?keyword',
        templateUrl: '/angular/lead/views/vendor/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.product', {
        url: '/product?keyword',
        templateUrl: '/angular/lead/views/product/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.concession', {
        url: '/concession?keyword',
        templateUrl: '/angular/lead/views/concession/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.contact', {
        url: '/contact?keyword',
        templateUrl: '/angular/lead/views/contact/index.view.html',
        roles: ['user', 'trader', 'manager']
      })

      //CREATE PAGES
      .state('lead.create-buyer', {
        url: '/buyer/create',
        templateUrl: '/angular/lead/views/buyer/create.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.create-seller', {
        url: '/seller/create',
        templateUrl: '/angular/lead/views/seller/create.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.create-vendor', {
        url: '/vendor/create',
        templateUrl: '/angular/lead/views/vendor/create.view.html',
        roles: ['user', 'trader', 'manager']
      })

      //SETUP PAGES
      .state('lead.setup-product-buyer', {
        url: '/buyer/{id}/setup-product',
        templateUrl: '/angular/lead/views/buyer/setup.product.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.setup-product-seller', {
        url: '/seller/{id}/setup-product',
        templateUrl: '/angular/lead/views/seller/setup.product.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.setup-factory', {
        url: '/buyer/setup-factory/{id}',
        templateUrl: '/angular/lead/views/factory/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.setup-concession-seller', {
        url: '/seller/setup-concession-seller/{id}',
        templateUrl: '/angular/lead/views/concession/index.view.html',
        roles: ['user', 'trader', 'manager']
      })

      //UPDATE PAGES
      .state('lead.update-buyer', {
        url: '/buyer/update/{id}',
        templateUrl: '/angular/lead/views/buyer/update.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.update-seller', {
        url: '/seller/update/{id}',
        templateUrl: '/angular/lead/views/seller/update.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.update-product', {
        url: '/product/update/{id}',
        templateUrl: '/angular/lead/views/product/update.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.update-vendor', {
        url: '/vendor/update/{id}',
        templateUrl: '/angular/lead/views/vendor/update.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.port-buyer', {
        url: '/port/buyer/{id}',
        templateUrl: '/angular/lead/views/port/buyer/index.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.port-seller', {
        url: '/port/seller/{id}',
        templateUrl: '/angular/lead/views/port/seller/index.view.html',
        roles: ['user', 'trader', 'manager']
      })

      //VIEW PAGES
      /*.state('lead.view', {
        url: '/{type}/{id}',
        templateUrl: '/angular/lead/views/view-lead.view.html',
        roles: ['user', 'trader', 'manager']
      })*/
      .state('lead.view-buyer', {
        url: '/buyer/{id}',
        templateUrl: '/angular/lead/views/buyer/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-seller', {
        url: '/seller/{id}',
        templateUrl: '/angular/lead/views/seller/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-vendor', {
        url: '/vendor/{id}',
        templateUrl: '/angular/lead/views/vendor/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-product', {
        url: '/product/{id}',
        templateUrl: '/angular/lead/views/product/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-concession', {
        url: '/concession/{id}',
        templateUrl: '/angular/lead/views/concession/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.update-concession', {
        url: '/concession/update/{id}',
        templateUrl: '/angular/lead/views/concession/update.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-factory', {
        url: '/factory/{id}',
        templateUrl: '/angular/lead/views/factory/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-contact', {
        url: '/contact/{id}',
        templateUrl: '/angular/lead/views/contact/view.view.html',
        roles: ['user']
      })
      .state('lead.update-port', {
        url: '/port/update/{portId}',
        templateUrl: '/angular/lead/views/port/update.port.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.view-port', {
        url: '/port/{portId}',
        templateUrl: '/angular/lead/views/port/view.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('lead.create', {
        url: '/create',
        templateUrl: '/angular/lead/views/create.view.html',
        roles: ['admin']
      });
  }
]);
