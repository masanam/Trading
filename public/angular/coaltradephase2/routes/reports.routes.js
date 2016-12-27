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
      .state('reports.balance-index', {
        url: '/balance-index',
        templateUrl: '/angular/coaltradephase2/views/reports/balance-index.view.html'
      })
      .state('reports.sales-index', {
        url: '/sales-index',
        templateUrl: '/angular/coaltradephase2/views/reports/sales-index.view.html'
      })
      .state('reports.expense-index', {
        url: '/expense-index',
        templateUrl: '/angular/coaltradephase2/views/reports/expense-index.view.html'
      });
      
  }
]);
