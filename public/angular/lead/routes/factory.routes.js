'use strict';

// Setting up route
angular.module('factory').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('factory', {
        url: '/factory',
        abstract: true,
        template: '<ui-view>'
      })
      .state('factory.index', {
        url: '',
        templateUrl: '/angular/lead/views/factory/index.view.html'
      })
      .state('factory.create', {
        url: '/create',
        templateUrl: '/angular/lead/views/factory/create.view.html'
      })
      .state('factory.view', {
        url: '/{id}',
        templateUrl: '/angular/lead/views/factory/view.view.html'
      })
      .state('factory.update', {
        url: '/{id}/update',
        templateUrl: '/angular/lead/views/factory/update.view.html'
      });
  }
]);