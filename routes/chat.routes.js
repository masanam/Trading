'use strict';

// Setting up route
angular.module('chat').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('chat', {
        url: '/chat',
        abstract: true,
        template: '<ui-view>'
      })
      .state('chat.index', {
        url: '',
        templateUrl: '/angular/chat/views/chat.view.html'
  	  })
      .state('chat.history', {
        url: '/history',
        templateUrl: '/angular/chat/views/history.view.html'
  	  })
  	  .state('chat.create', {
        url: '/create',
        templateUrl: '/angular/chat/views/create.view.html'
      })
  	  .state('chat.view', {
        url: '/{id}',
        templateUrl: '/angular/chat/views/view.view.html'
      })
      .state('chat.update', {
        url: '/{id}/update',
        templateUrl: '/angular/chat/views/update.view.html'
      });
  }
]);