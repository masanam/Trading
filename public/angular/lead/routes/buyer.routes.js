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
        templateUrl: '/angular/lead/views/buyer/index.view.html'
      })
      .state('buyer.create', {
        url: '/create',
        templateUrl: '/angular/lead/views/buyer/create.view.html'
      })
      .state('buyer.view', {
        url: '/{id}',
        templateUrl: '/angular/lead/views/buyer/view.view.html'
      })
      .state('buyer.update', {
        url: '/{id}/update',
        templateUrl: '/angular/lead/views/buyer/update.view.html'
      });
  }
]);
