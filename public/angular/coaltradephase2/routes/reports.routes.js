'use strict';

// Setting up route
angular.module('reports').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('reports', {
        url: '/reports',
        abstract: true,
        template: '<ui-view>'
      })
      .state('reports.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/reports/dashboard.view.html'
      })
      .state('reports.index', {
        url: '/index',
        templateUrl: '/angular/coaltradephase2/views/reports/index.view.html'
      });
      
  }
]);
