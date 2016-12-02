'use strict';

// Setting up route
angular.module('vendor').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('vendor', {
        url: '/coalpedia/vendor',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('vendor.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/vendor/list.view.html',
        roles: ['user', 'trader', 'manager']
      });
  }
]);
