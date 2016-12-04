'use strict';

// Setting up route
angular.module('concession').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('concession', {
        url: '/coalpedia/concession',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('concession.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/concession/list.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('concession.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/concession/view.view.html' } },
        roles: ['user', 'trader', 'manager']
      });
  }
]);
