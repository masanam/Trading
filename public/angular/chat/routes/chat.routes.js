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
        templateUrl: '/angular/deal/views/deal.view.html'
  	  })
      .state('deal.history', {
        url: '/history',
        templateUrl: '/angular/deal/views/history.view.html'
  	  })
  	  .state('deal.create', {
        url: '/create',
        templateUrl: '/angular/deal/views/create.view.html'
      })
  	  .state('deal.view', {
        url: '/{id}',
        templateUrl: '/angular/deal/views/view.view.html'
      })
      .state('deal.update', {
        url: '/{id}/update',
        templateUrl: '/angular/deal/views/update.view.html'
      });
  }
]);