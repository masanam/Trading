'use strict';

// Setting up route
angular.module('map').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('map', {
        url: '/map',
        abstract: true,
        template: '<ui-view>'
      })
      .state('map.index', {
        url: '',
        templateUrl: '/angular/map/views/index.view.html',
        privileges: [
          'order.view', 'order.edit',
          'lead.view', 'lead.edit',
          'coalpedia.view', 'coalpedia.edit',
          'index.view', 'index.edit',
        ]
      });
  }
]);
