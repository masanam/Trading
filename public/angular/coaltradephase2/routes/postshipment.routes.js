'use strict';

// Setting up route
angular.module('postshipment').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('postshipment', {
        url: '/postshipment',
        abstract: true,
        template: '<ui-view>'
      })
      .state('postshipment.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/postshipment/index.view.html'
      });
      
  }
]);
