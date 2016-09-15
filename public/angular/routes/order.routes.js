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
        templateUrl: '/angular/views/order/order.view.html'
      })
      .state('order.history', {
        url: '/history',
        templateUrl: '/angular/views/order/history.view.html'
      })
      .state('order.viewBuyer', {
        url: '/buyer/:buyerId',
        templateUrl: '/angular/views/order/history.view.html'
      })
      .state('order.unattended-order', {
        url: '/wait-for-call',
        templateUrl: '/angular/views/order/unattended-order.view.html'
      })
      .state('order.unmatched-order', {
        url: '/wait-for-match',
        templateUrl: '/angular/views/order/unmatched-order.view.html'
      })
      .state('order.matched-order', {
        url: '/wait-for-nego',
        templateUrl: '/angular/views/order/matched-order.view.html'
      })
      .state('order.due-today', {
        url: '/due-today',
        templateUrl: '/angular/views/order/due-today.view.html'
      })
      .state('order.view', {
        url: '/:id',
        templateUrl: '/angular/views/order/view-order-buyer.view.html'
      });
  }
]);