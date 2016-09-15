'use strict';

// Setting up route
angular.module('contact').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('contact', {
        url: '/contact',
        abstract: true,
        template: '<ui-view>'
      })
      .state('contact.index', {
        url: '',
        templateUrl: '/angular/views/contact/contact.view.html'
  	  });
  }
]);