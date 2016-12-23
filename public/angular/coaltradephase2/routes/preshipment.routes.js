'use strict';

// Setting up route
angular.module('preshipment').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('preshipment', {
        url: '/preshipment',
        abstract: true,
        template: '<ui-view>'
      })
      .state('preshipment.dashboard', {
        url: '/dashboard',
        templateUrl: '/angular/coaltradephase2/views/preshipment/index.view.html'
      });
      
  }
]);
