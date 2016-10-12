'use strict';

// Setting up route
angular.module('vendor').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('vendor', {
        url: '/vendor',
        abstract: true,
        template: '<ui-view>'
      })
      .state('vendor.index', {
        url: '',
        templateUrl: '/angular/views/vendor/vendor.view.html'
      })
      .state('vendor.create', {
        url: '/create',
        templateUrl: '/angular/views/vendor/create.view.html'
      })
      .state('vendor.view', {
        url: '/{id}',
        templateUrl: '/angular/views/vendor/view.view.html'
      })
      .state('vendor.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/vendor/update.view.html'
      });
  }
]);
