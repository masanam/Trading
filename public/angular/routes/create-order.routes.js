'use strict';

// Setting up route
angular.module('order-history').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('create-order', {
        url: '/create-order',
        abstract: true,
        template: '<ui-view>'
      })
      .state('create-order.index', {
        url: '',
        templateUrl: '/angular/views/order/order-list.view.html'
      })
      .state('create-order.createView', {
        url: '/createView',
        templateUrl: '/angular/views/order/order-list.view.html'
      });
  }
]);