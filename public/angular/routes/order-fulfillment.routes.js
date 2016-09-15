'use strict';

// Setting up route
angular.module('order').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('order-fulfillment', {
        url: '/order-fulfillment',
        abstract: true,
        template: '<ui-view>'
      })
      .state('order-fulfillment.ongoing-trade', {
        url: '/ongoing-trade',
        templateUrl: '/angular/views/order-fulfillment/ongoing-trade.view.html'
      })
      .state('order-fulfillment.log', {
        url: '/log',
        templateUrl: '/angular/views/order-fulfillment/log.view.html'
      })
      .state('order-fulfillment.history', {
        url: '/history',
        templateUrl: '/angular/views/order-fulfillment/history.view.html'
      })
      .state('order-fulfillment.waiting-for-call', {
        url: '/waiting-for-call',
        templateUrl: '/angular/views/order-fulfillment/waiting-for-call.view.html'
      })
      .state('order-fulfillment.waiting-for-nego', {
        url: '/waiting-for-nego',
        templateUrl: '/angular/views/order-fulfillment/waiting-for-nego.view.html'
      })
      .state('order-fulfillment.waiting-for-shipment', {
        url: '/waiting-for-shipment',
        templateUrl: '/angular/views/order-fulfillment/waiting-for-shipment.view.html'
      })
      .state('order-fulfillment.waiting-for-closing', {
        url: '/waiting-for-closing',
        templateUrl: '/angular/views/order-fulfillment/waiting-for-closing.view.html'
      })
      .state('order-fulfillment.due-today', {
        url: '/due-today',
        templateUrl: '/angular/views/order-fulfillment/due-today.view.html'
      })
      .state('order-fulfillment.historySeller', {
        url: '/history/{sellerId}',
        templateUrl: '/angular/views/order-fulfillment/history.view.html'
      })
      .state('order-fulfillment.kanban', {
        url: '/kanban',
        templateUrl: '/angular/views/order-fulfillment/kanban.view.html'
      })
      .state('order-fulfillment.show', {
        url: '/{id}',
        templateUrl: '/angular/views/order-fulfillment/show.view.html'
      });
  }
]);