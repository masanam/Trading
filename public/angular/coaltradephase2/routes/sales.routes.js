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
        templateUrl: '/angular/coaltradephase2/views/sales/index.view.html'
      });
      
  }
]);
