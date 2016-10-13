'use strict';

// Setting up route
angular.module('concession').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('concession', {
        url: '/concession',
        abstract: true,
        template: '<ui-view>'
      })
      .state('concession.index', {
        url: '',
        templateUrl: '/angular/views/concession/index.view.html'
      })
      .state('concession.create', {
        url: '/create',
        templateUrl: '/angular/views/concession/create.view.html'
      })
      .state('concession.view', {
        url: '/{id}',
        templateUrl: '/angular/views/concession/view.view.html'
      })
      .state('concession.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/concession/update.view.html'
      });
  }
]);