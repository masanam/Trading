'use strict';

// Setting up route
angular.module('bizdev').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('bizdev', {
        url: '/bizdev',
        abstract: true,
        template: '<ui-view>'
      })
      .state('bizdev.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/bizdev/views/dashboard.html'
      })
      .state('bizdev.iup-management', {
        url: '/iup',
        templateUrl: '/angular/bizdev/views/iup/index.view.html'
      })
      .state('bizdev.iup-history', {
        url: '/iup-history',
        templateUrl: '/angular/bizdev/views/iup/history.view.html'
      })
      .state('bizdev.iup-view', {
        url: '/iup-view',
        templateUrl: '/angular/bizdev/views/iup/iup.view.html'
      });
      
  }
]);