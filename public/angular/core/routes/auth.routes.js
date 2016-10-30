'use strict';

// Setting up route
angular.module('auth').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('auth', {
        url: '/auth',
        abstract: true,
        template: '<ui-view>'
      })
      .state('auth.signin', {
        url: '/signin',
        templateUrl: '/angular/core/views/auth/signin.view.html'
      })
      .state('auth.signup', {
        url: '/signup',
        templateUrl: '/angular/core/views/auth/signup.view.html'
      })
      .state('auth.forgot', {
        url: '/forgot',
        templateUrl: '/angular/core/views/user/forgot-password.view.html'
      });
  }
]);