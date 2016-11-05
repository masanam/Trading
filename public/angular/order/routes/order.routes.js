'use strict';

// Setting up route
angular.module('order').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('order', {
        url: '/order',
        abstract: true,
        template: '<ui-view>'
      })
      .state('order.index', {
        url: '',
        templateUrl: '/angular/order/views/order/index.view.html'
      });



    $stateProvider
      .state('buy-order', {
        url: '/buy-order',
        abstract: true,
        template: '<ui-view>'
      })
      .state('buy-order.index', {
        url: '',
        templateUrl: '/angular/order/views/buy-order/index.view.html'
      })
      .state('buy-order.create', {
        url: '/create',
        templateUrl: '/angular/order/views/buy-order/step.customer.view.html'
      })
      .state('buy-order.step-customer', {
        url: '/create/customer/:order_id',
        templateUrl: '/angular/order/views/buy-order/step.customer.view.html'
      })
      .state('buy-order.step-factory', {
        url: '/create/factory/:id/:order_id',
        templateUrl: '/angular/order/views/buy-order/step.factory.view.html'
      })
      .state('buy-order.step-product', {
        url: '/create/product/:id/:order_id/:factory_id',
        templateUrl: '/angular/order/views/buy-order/step.product.view.html'
      })
      .state('buy-order.step-port', {
        url: '/create/port/:id/:order_id/:factory_id',
        templateUrl: '/angular/order/views/buy-order/step.port.view.html'
      })
      .state('buy-order.step-summary', {
        url: '/create/summary/:id/:order_id/:factory_id',
        templateUrl: '/angular/order/views/buy-order/step.summary.view.html'
      })
      .state('buy-order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/buy-order/view.view.html'
      })
      .state('buy-order.update', {
        url: '/update/:id',
        templateUrl: '/angular/order/views/buy-order/update.view.html'
      });

    $stateProvider
      .state('sell-order', {
        url: '/sell-order',
        abstract: true,
        template: '<ui-view>'
      })
      .state('sell-order.index', {
        url: '',
        templateUrl: '/angular/order/views/sell-order/index.view.html'
      })
      .state('sell-order.create', {
        url: '/create',
        templateUrl: '/angular/order/views/sell-order/step.supplier.view.html'
      })
      .state('sell-order.step-supplier', {
        url: '/create/supplier/:order_id',
        templateUrl: '/angular/order/views/sell-order/step.supplier.view.html'
      })
      .state('sell-order.step-concession', {
        url: '/create/concession/:id/:order_id',
        templateUrl: '/angular/order/views/sell-order/step.concession.view.html'
      })
      .state('sell-order.step-product', {
        url: '/create/product/:id/:order_id/:concession_id',
        templateUrl: '/angular/order/views/sell-order/step.product.view.html'
      })
      .state('sell-order.step-port', {
        url: '/create/port/:id/:order_id/:concession_id',
        templateUrl: '/angular/order/views/sell-order/step.port.view.html'
      })
      .state('sell-order.step-summary', {
        url: '/create/summary/:id/:order_id/:concession_id',
        templateUrl: '/angular/order/views/sell-order/step.summary.view.html'
      })
      .state('sell-order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/sell-order/view.view.html'
      })
      .state('sell-order.update', {
        url: '/update/:id',
        templateUrl: '/angular/order/views/sell-order/update.view.html'
      });

    $stateProvider
      .state('buy-order-management', {
        url: '/buy-order-management',
        abstract: true,
        template: '<ui-view>'
      })
      .state('buy-order-management.index', {
        url: '',
        templateUrl: '/angular/order/views/buy-order/management.view.html'
      });

    $stateProvider
      .state('sell-order-management', {
        url: '/sell-order-management',
        abstract: true,
        template: '<ui-view>'
      })
      .state('sell-order-management.index', {
        url: '',
        templateUrl: '/angular/order/views/sell-order/management.view.html'
      });

    $stateProvider
      .state('history-order', {
        url: '/history-order',
        abstract: true,
        template: '<ui-view>'
      })
      .state('history-order.index', {
        url: '',
        templateUrl: '/angular/order/views/history/index.view.html'
      });
  }
]);