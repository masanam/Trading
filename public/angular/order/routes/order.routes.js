'use strict';

// Setting up route
angular.module('order').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('order', {
        url: '/order',
        abstract: true,
        templateUrl: '/angular/order/views/main.layout.html'
      })
      .state('order.list', {
        url: '',
        templateUrl: '/angular/order/views/list.view.html',
        privileges: ['order.view', 'order.edit', 'order.approval']
      })
      .state('order.create', {
        url: '/create',
        templateUrl: '/angular/order/views/create.view.html',
        privileges: ['order.edit', 'order.approval']
      })
      .state('order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/view.view.html',
        privileges: ['order.view', 'order.edit', 'order.approval']
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