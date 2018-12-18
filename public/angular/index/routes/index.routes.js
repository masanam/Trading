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
        roles: ['index.edit']
      })
      .state('index.view', {
        url: '/:indexId',
        templateUrl: '/angular/index/views/view.view.html'
      })
      .state('index.edit', {
        url: '/:indexId/edit',
        templateUrl: '/angular/index/views/edit.view.html',
        roles: ['index.edit']
      })

      // Update Index Price
      .state('index.today-price', {
        url: '/price/today',
        templateUrl: '/angular/index/views/index-price/today.view.html',
        roles: ['index.edit']
      })

      // Update Index Price
      .state('index.edit_previous-price', {
        url: '/price/edit_previous',
        templateUrl: '/angular/index/views/index-price/edit_previous-price.view.html',
        roles: ['index.edit']
      })
      // Update Index Price
      .state('index.edit-price', {
        url: '/:indexId/price/:indexPriceId/edit',
        templateUrl: '/angular/index/views/index-price/edit.view.html',
        roles: ['index.edit']
      });
  }
]);