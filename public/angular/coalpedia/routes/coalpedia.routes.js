'use strict';

// Setting up route
angular.module('lead').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('coalpedia', {
        url: '/coalpedia',
        abstract: true,
        template: '<ui-view/>'
      })
      .state('coalpedia.index', {
        url: '',
        templateUrl: '/angular/coalpedia/views/index.view.html',
        privileges: ['coalpedia.view']
      });
  }
]);
