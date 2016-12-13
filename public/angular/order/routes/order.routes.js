'use strict';

// Setting up route
angular.module('order').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('order', {
        url: '/order',
        abstract: true,
        templateUrl: '/angular/order/views/order/main.layout.html',
        roles: ['trader', 'manager']
      })
      .state('order.list', {
        url: '',
        templateUrl: '/angular/order/views/order/list.view.html',
        roles: ['trader', 'manager']
      })
      .state('order.create', {
        url: '/create',
        templateUrl: '/angular/order/views/order/create.view.html',
        roles: ['trader', 'manager']
      })
      .state('order.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/order/view.view.html',
        roles: ['trader', 'manager']
      });

    $stateProvider
      .state('lead', {
        url: '/lead',
        abstract: true,
        templateUrl: '/angular/order/views/lead/main.layout.html',
        roles: ['trader', 'manager']
      })
      .state('lead.list', {
        url: '',
        templateUrl: '/angular/order/views/lead/list.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.create', {
        url: '/create',
        templateUrl: '/angular/order/views/lead/create.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.view', {
        url: '/:id',
        templateUrl: '/angular/order/views/lead/view.view.html',
        roles: ['trader', 'manager']
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