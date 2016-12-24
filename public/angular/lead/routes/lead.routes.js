'use strict';

// Setting up route
angular.module('lead').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('lead', {
        url: '/lead',
        abstract: true,
        template: '<ui-view>'
      })
      .state('lead.list', {
        url: '?status&lead_type',
        templateUrl: '/angular/lead/views/list.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.create', {
        url: '/create?lead_type',
        templateUrl: '/angular/lead/views/wizard/create.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.update', {
        url: '/:id/update',
        templateUrl: '/angular/lead/views/wizard/update.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.location', {
        url: '/:id/location',
        templateUrl: '/angular/lead/views/wizard/location.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.port', {
        url: '/:id/port',
        templateUrl: '/angular/lead/views/wizard/port.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.product', {
        url: '/:id/product',
        templateUrl: '/angular/lead/views/wizard/product.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.view', {
        url: '/:id',
        templateUrl: '/angular/lead/views/view.view.html',
        roles: ['trader', 'manager']
      });
  }
]);
