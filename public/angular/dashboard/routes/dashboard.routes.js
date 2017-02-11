'use strict';

// Setting up route
angular.module('dashboard').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('dashboard', {
        url: '/dashboard',
        abstract: true,
        template: '<ui-view>'
      })
      .state('dashboard.main', {
        url: '/main',
        templateUrl: '/angular/dashboard/views/main.view.html',
        privileges: [
          'order.view', 'order.edit',
          'lead.view', 'lead.edit',
          'coalpedia.view', 'coalpedia.edit',
          'index.view', 'index.edit',
        ]
      })
      .state('dashboard.map', {
        url: '/map',
        templateUrl: '/angular/dashboard/views/map.view.html',
        privileges: [
          'order.view', 'order.edit',
          'lead.view', 'lead.edit',
          'coalpedia.view', 'coalpedia.edit',
          'index.view', 'index.edit',
        ]
      })
      .state('dashboard.index', {
        url: '/index',
        templateUrl: '/angular/dashboard/views/index.view.html',
        privileges: [
          'order.view', 'order.edit',
          'lead.view', 'lead.edit',
          'coalpedia.view', 'coalpedia.edit',
          'index.view', 'index.edit',
        ]
      });
  }
]);