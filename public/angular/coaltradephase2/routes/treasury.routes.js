'use strict';

// Setting up route
angular.module('treasury').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('treasury', {
        url: '/treasury',
        abstract: true,
        template: '<ui-view>'
      })
      .state('treasury.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/treasury/dashboard.view.html'
      })
      .state('treasury.index', {
        url: '/index',
        templateUrl: '/angular/coaltradephase2/views/treasury/index.view.html'
      });
      
  }
]);
