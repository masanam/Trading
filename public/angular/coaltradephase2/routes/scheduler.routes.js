'use strict';

// Setting up route
angular.module('scheduler').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('scheduler', {
        url: '/scheduler',
        abstract: true,
        template: '<ui-view>'
      })
      .state('scheduler.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/scheduler/index.view.html'
      });
      
  }
]);
