'use strict';

// Setting up route
angular.module('coalpedia').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('factory', {
        url: '/coalpedia/factory',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('factory.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/factory/list.view.html',
        privileges: [
          'coalpedia.view', 'coalpedia.edit',
        ]
      })
      .state('factory.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/factory/view.view.html' } },
        privileges: [
          'coalpedia.view', 'coalpedia.edit',
        ]
      });
  }
]);
