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
        url: '/deal/{dealId}',
        templateUrl: '/angular/chat/views/view-chat.view.html'
      });

  }
]);