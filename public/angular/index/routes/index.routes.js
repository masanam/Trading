'use strict';

// Setting up route
angular.module('index').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('index', {
        url: '/index',
        abstract: true,
        templateUrl: '/angular/index/views/main.layout.html'
      })
      .state('index.list', {
        url: '',
        templateUrl: '/angular/index/views/list.view.html'
      })

      // Index In General
      .state('index.create', {
        url: '/create',
        templateUrl: '/angular/index/views/create.view.html',
        roles: ['manager']
      })
      .state('index.view', {
        url: '/:indexId',
        templateUrl: '/angular/index/views/view.view.html'
      })
      .state('index.edit', {
        url: '/:indexId/edit',
        templateUrl: '/angular/index/views/edit.view.html',
        roles: ['manager']
      })

      // Add Index Price of specific Index 
      .state('index.create-price', {
        url: '/:indexId/price/create',
        templateUrl: '/angular/index/views/create.view.html',
        roles: ['manager']
      })
      // Update Index Price
      .state('index.edit-price', {
        url: '/:indexId/price/:indexPriceId/edit',
        templateUrl: '/angular/index/views/edit-price.view.html',
        roles: ['manager']
      });
  }
]);