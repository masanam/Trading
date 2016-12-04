'use strict';

// Setting up route
angular.module('coalpedia').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('company', {
        url: '/coalpedia/company/:type',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('company.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/company/list.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('company.create', {
        url: '/create',
        templateUrl: '/angular/coalpedia/views/company/create.view.html',
        roles: ['user', 'trader', 'manager']
      })
      .state('company.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/company/view.view.html' } },
        roles: ['user', 'trader', 'manager']
      });
  }
]);
