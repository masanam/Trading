'use strict';

// Setting up route
angular.module('buyer').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('buyer', {
        url: '/coalpedia/buyer',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('buyer.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/company/list.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('buyer.create', {
        url: '/create',
        templateUrl: '/angular/coalpedia/views/company/create.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('buyer.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/company/view.view.html' } },
        roles: ['user', 'trader', 'manager']
      });
  }
]);
