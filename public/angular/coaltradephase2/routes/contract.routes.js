'use strict';

// Setting up route
angular.module('contract').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('contract', {
        url: '/contract',
        abstract: true,
        template: '<ui-view>'
      })
      .state('contract.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/contract/dashboard.view.html'
      });
      
  }
]);
