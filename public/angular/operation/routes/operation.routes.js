'use strict';

// Setting up route
angular.module('operation').config(['$stateProvider','$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('operation', {
        url: '/operation',
        abstract: true,
        template: '<ui-view>'
      })

      .state('operation.index', {
        url: '',
        templateUrl: '/angular/operation/views/index.view.html',
        roles: ['trader', 'manager', 'admin']
      })

      .state('operation.view-preship', {
        url: '/preshipment/{id}',
        templateUrl: '/angular/operation/views/preshipment.view.html',
        roles: ['trader', 'manager', 'admin']
      })

      .state('operation.view-shipment', {
        url: '/shipment/{id}',
        templateUrl: '/angular/operation/views/shipment.view.html',
        roles: ['trader', 'manager', 'admin']
      })

      .state('operation.view-postshipment', {
        url: '/postshipment/{id}',
        templateUrl: '/angular/operation/views/postshipment.view.html',
        roles: ['trader', 'manager', 'admin']
      });

  }
]);