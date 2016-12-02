'use strict';

// Setting up route
angular.module('seller').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('seller', {
        url: '/coalpedia/seller',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('seller.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/seller/list.view.html',
        roles: ['user', 'trader', 'manager']
      });
  }
]);
