'use strict';

// Setting up route
angular.module('sales').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('sales', {
        url: '/sales',
        abstract: true,
        template: '<ui-view>'
      })
      .state('sales.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/sales/dashboard.view.html'
      })
      .state('sales.ongoing', {
        url: '/ongoing',
        templateUrl: '/angular/coaltradephase2/views/sales/ongo.view.html'
      })
      .state('sales.order-history', {
        url: '/history',
        templateUrl: '/angular/coaltradephase2/views/sales/orderhistory.view.html'
      });
      
  }
]);
