'use strict';

// Setting up route
angular.module('coalpedia').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('product', {
        url: '/coalpedia/product',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('product.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/product/list.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('product.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/product/view.view.html' } },
        roles: ['user', 'trader', 'manager']
      });
  }
]);
