'use strict';

// Setting up route
angular.module('coalpedia').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('port', {
        url: '/coalpedia/port',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('port.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/port/list.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('port.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/port/view.view.html' } },
        roles: ['user', 'trader', 'manager']
      });
  }
]);
