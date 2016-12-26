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
        templateUrl: '/angular/coaltradephase2/views/scheduler/dashboard.view.html'
      })
      .state('scheduler.current-shipment', {
        url: '/currentshipment',
        templateUrl: '/angular/coaltradephase2/views/scheduler/currentshipment.view.html'
      })
      .state('scheduler.history-shipment', {
        url: '/historyshipment',
        templateUrl: '/angular/coaltradephase2/views/scheduler/currenthistory.view.html'
      });
      
  }
]);
