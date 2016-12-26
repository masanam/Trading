'use strict';

// Setting up route
angular.module('usermanagement').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('usermanagement', {
        url: '/usermanagement',
        abstract: true,
        template: '<ui-view>'
      })
      .state('usermanagement.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/usermanagement/dashboard.view.html'
      })
      .state('usermanagement.index', {
        url: '/index',
        templateUrl: '/angular/coaltradephase2/views/usermanagement/index.view.html'
      });
      
  }
]);
