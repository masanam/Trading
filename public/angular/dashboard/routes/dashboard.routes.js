'use strict';

// Setting up route
angular.module('dashboard').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('dashboard', {
        url: '/dashboard',
        abstract: true,
        template: '<ui-view>'
      })
      .state('dashboard.main', {
        url: '/main',
        templateUrl: '/angular/dashboard/views/main.view.html',
        roles: ['trader', 'manager', 'admin']
      })
      .state('dashboard.map', {
        url: '/map',
        templateUrl: '/angular/dashboard/views/map.view.html',
        roles: ['trader', 'manager', 'admin']
      })
      .state('dashboard.index', {
        url: '/index',
        templateUrl: '/angular/dashboard/views/index.view.html',
        roles: ['trader', 'manager', 'admin']
      });
  }
]);