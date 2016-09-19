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
        roles: ['user', 'trader']
  	  })
  	  .state('lead.buyer', {
        url: '/buyer',
        templateUrl: '/angular/views/lead/buyer.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.seller', {
        url: '/seller',
        templateUrl: '/angular/views/lead/seller.view.html',
        roles: ['user', 'trader']
      })      
      .state('lead.search-buyer', {
        url: '/search/buyer/{keyword}',
        templateUrl: '/angular/views/lead/search.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.search-seller', {
        url: '/search/seller/{keyword}',
        templateUrl: '/angular/views/lead/search.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.search-vendor', {
        url: '/search/vendor/{keyword}',
        templateUrl: '/angular/views/lead/search.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.search-contact', {
        url: '/search/contact/{keyword}',
        templateUrl: '/angular/views/lead/search.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.vendor', {
        url: '/vendor',
        templateUrl: '/angular/views/lead/vendor.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.contact', {
        url: '/contact',
        templateUrl: '/angular/views/lead/contact.view.html',
        roles: ['user', 'trader']
      })
  	  .state('lead.view-buyer', {
        url: '/buyer/{id}',
        templateUrl: '/angular/views/lead/view-buyer.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-seller', {
        url: '/seller/{id}',
        templateUrl: '/angular/views/lead/view-seller.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-vendor', {
        url: '/vendor/{id}',
        templateUrl: '/angular/views/lead/view-vendor.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-contact', {
        url: '/contact/{id}',
        templateUrl: '/angular/views/lead/view-contact.view.html',
        roles: ['user']
      })
      .state('lead.create', {
        url: '/create',
        templateUrl: '/angular/views/lead/create.view.html',
        roles: ['admin']
      });
  }
]);
