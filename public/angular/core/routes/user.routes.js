'use strict';

// Setting up route
angular.module('user').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('user', {
        url: '/user',
        abstract: true,
        template: '<ui-view>'
      })
      .state('user.edit', {
        url: '/edit',
        templateUrl: '/angular/core/views/user/update.view.html'
      })
      .state('user.password', {
        url: '/password',
        templateUrl: '/angular/core/views/user/reset-password.view.html'
      });
  }
]);