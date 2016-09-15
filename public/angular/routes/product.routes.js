'use strict';

// Setting up route
angular.module('product').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('product', {
        url: '/product',
        abstract: true,
        template: '<ui-view>'
      })
      .state('product.index', {
        url: '',
        templateUrl: '/angular/views/product/product.view.html'
      })
      .state('product.create', {
        url: '/create?:mine',
        templateUrl: '/angular/views/product/create.view.html'
      })
      .state('product.history', {
        url: '/history',
        templateUrl: '/angular/views/product/history.view.html'
      })
      .state('product.add', {
        url: '/{id}/add',
        templateUrl: '/angular/views/product/add.view.html'
      })
      .state('product.opname', {
        url: '/{id}/opname',
        templateUrl: '/angular/views/product/opname.view.html'
      })
      .state('product.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/product/update.view.html'
      })
      .state('product.search-order', {
        url: '/{id}/search-order',
        templateUrl: '/angular/views/product/search-order.view.html'
      });
  }
]);
