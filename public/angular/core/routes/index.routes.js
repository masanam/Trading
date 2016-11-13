'use strict';

// Setting up route
angular.module('index').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {

    // Redirect to 404 when route not found
    $urlRouterProvider.otherwise(function ($injector, $location) {
      $injector.get('$state').transitionTo('not-found', null, {
        location: false
      });
    });

    // Home state routing
    $stateProvider
      .state('home', {
        url: '/',
        templateUrl: '/angular/core/views/index/home.view.html'
      })
      .state('notification', {
        url: '/notification',
        templateUrl: '/angular/core/views/user/notification.view.html'
      })
      .state('analytics', {
        url: '/analytics',
        templateUrl: '/angular/core/views/index/analytics.view.html'
      })
      .state('not-found', {
        url: '/not-found',
        templateUrl: '/angular/core/views/index/404.view.html',
        data: {
          ignoreState: true
        }
      })
      .state('bad-request', {
        url: '/bad-request',
        templateUrl: '/angular/core/views/index/400.view.html',
        data: {
          ignoreState: true
        }
      })
      .state('forbidden', {
        url: '/forbidden',
        templateUrl: '/angular/core/views/index/403.view.html',
        data: {
          ignoreState: true
        }
      });
  }
]);
