'use strict';

// Setting up route
angular.module('bizdev').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('bizdev', {
        url: '/index',
        abstract: true,
        templateUrl: '/angular/index/views/main.layout.html'
      })
      .state('bizdev.dashboard', {
        url: '',
        templateUrl: '/angular/index/views/list.view.html'
      })
      .state('bizdev.iup-management', {
        url: '/create',
        templateUrl: '/angular/index/views/create.view.html'
      });
      
  }
]);