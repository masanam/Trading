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
        url: '?status',
        templateUrl: '/angular/lead/views/list.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.create', {
        url: '/create?lead_type',
        templateUrl: '/angular/lead/views/wizard/create.view.html',
        roles: ['trader', 'manager']
      })
      .state('lead.view', {
        url: '/:id',
        templateUrl: '/angular/lead/views/view.view.html',
        roles: ['trader', 'manager']
      });
  }
]);
