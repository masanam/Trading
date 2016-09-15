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
      .state('lead.index', {
        url: '',
        templateUrl: '/angular/views/lead/index.view.html',
        roles: ['user']
  	  })
  	  .state('lead.buyer', {
        url: '/buyer',
        templateUrl: '/angular/views/lead/buyer.view.html'
      })
      .state('lead.seller', {
        url: '/seller',
        templateUrl: '/angular/views/lead/seller.view.html'
      })
      .state('lead.vendor', {
        url: '/vendor',
        templateUrl: '/angular/views/lead/vendor.view.html'
      })
      .state('lead.contact', {
        url: '/contact',
        templateUrl: '/angular/views/lead/contact.view.html'
      })
  	  .state('lead.view-buyer', {
        url: '/buyer/{id}',
        templateUrl: '/angular/views/lead/view-buyer.view.html'
      })
      .state('lead.view-seller', {
        url: '/seller/{id}',
        templateUrl: '/angular/views/lead/view-seller.view.html'
      })
      .state('lead.view-vendor', {
        url: '/vendor/{id}',
        templateUrl: '/angular/views/lead/view-vendor.view.html'
      })
      .state('lead.view-contact', {
        url: '/contact/{id}',
        templateUrl: '/angular/views/lead/view-contact.view.html'
      })
      .state('lead.create', {
        url: '/create',
        templateUrl: '/angular/views/lead/create.view.html'
      });
  }
]);
