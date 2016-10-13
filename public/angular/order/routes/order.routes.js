'use strict';

// Setting up route
angular.module('order-history').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('order', {
        url: '/order',
        abstract: true,
        template: '<ui-view>'
      })
      .state('order.index', {
        url: '',
        templateUrl: '/angular/order/views//index.view.html'
      })
      .state('order.history', {
        url: '/history',
        templateUrl: '/angular/order/views//history.view.html'
      })
      .state('order.viewBuyer', {
        url: '/buyer/:buyerId',
        templateUrl: '/angular/order/views//history.view.html'
      })
      .state('order.unattended-order', {
        url: '/wait-for-call',
        templateUrl: '/angular/order/views//unattended-order.view.html'
      })
      .state('order.unmatched-order', {
        url: '/wait-for-match',
        templateUrl: '/angular/order/views//unmatched-order.view.html'
      })
      .state('order.matched-order', {
        url: '/wait-for-nego',
        templateUrl: '/angular/order/views//matched-order.view.html'
      })
      .state('order.due-today', {
        url: '/due-today',
        templateUrl: '/angular/order/views//due-today.view.html'
      })
      .state('order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views//view-order-buyer.view.html'
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
        templateUrl: '/angular/order/views/buy-order/form.view.html'
      })
      .state('buy-order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/buy-order/view.view.html'
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
      .state('sell-order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/sell-order/view.view.html'
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
  }
]);