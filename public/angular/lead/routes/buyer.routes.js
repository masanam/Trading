'use strict';

// Setting up route
angular.module('buyer').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('buyer', {
        url: '/buyer',
        abstract: true,
        template: '<ui-view>'
      })
      .state('buyer.index', {
        url: '',
        templateUrl: '/angular/views/buyer/buyer.view.html'
      })
      .state('buyer.create', {
        url: '/create',
        templateUrl: '/angular/views/buyer/create.view.html'
      })
      .state('buyer.view', {
        url: '/{id}',
        templateUrl: '/angular/views/buyer/buyer.view.html'
      })
      .state('buyer.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/buyer/update.view.html'
      });
  }
]);
