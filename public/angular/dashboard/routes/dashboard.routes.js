'use strict';

// Setting up route
angular.module('dashboard').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('dashboard', {
        url: '/dashboard',
        abstract: true,
        template: '<ui-view>'
      })
      .state('dashboard.map', {
        url: '/map',
        templateUrl: '/angular/dashboard/views/map.view.html'
      })
      .state('dashboard.index', {
        url: '/index',
        templateUrl: '/angular/dashboard/views/index.view.html'
      });
  }
]);