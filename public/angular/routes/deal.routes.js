'use strict';

// Setting up route
angular.module('deal').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('deal', {
        url: '/deal',
        abstract: true,
        template: '<ui-view>'
      })
      .state('deal.index', {
        url: '',
        templateUrl: '/angular/views/deal/deal.view.html'
  	  })
      .state('deal.history', {
        url: '/history',
        templateUrl: '/angular/views/deal/history.view.html'
  	  })
  	  .state('deal.create', {
        url: '/create',
        templateUrl: '/angular/views/deal/create.view.html'
      })
  	  .state('deal.view', {
        url: '/{id}',
        templateUrl: '/angular/views/deal/view.view.html'
      })
      .state('deal.update', {
        url: '/{id}/update',
        templateUrl: '/angular/views/deal/update.view.html'
      });
  }
]);