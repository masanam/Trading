'use strict';

// Setting up route
angular.module('mine').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('mine', {
        url: '/mine',
        abstract: true,
        template: '<ui-view>'
      })
      .state('mine.index', {
        url: '',
        templateUrl: '/angular/views/mine/mine.view.html'
      })
      .state('mine.create', {
        url: '/create',
        templateUrl: '/angular/views/mine/create.view.html'
      })
      .state('mine.view', {
        url: '/{id}',
        templateUrl: '/angular/views/mine/view.view.html'
      })
      .state('mine.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/mine/update.view.html'
      });
  }
]);