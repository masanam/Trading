'use strict';

// Setting up route
angular.module('seller').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('seller', {
        url: '/seller',
        abstract: true,
        template: '<ui-view>'
      })
      .state('seller.index', {
        url: '',
        templateUrl: '/angular/views/seller/seller.view.html'
  	  })
  	  .state('seller.create', {
        url: '/create',
        templateUrl: '/angular/views/seller/create.view.html'
      })
  	  .state('seller.view', {
        url: '/{id}',
        templateUrl: '/angular/views/seller/view.view.html'
      })
      .state('seller.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/seller/update.view.html'
      });
  }
]);
