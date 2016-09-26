'use strict';

// Setting up route
angular.module('lead').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('lead', {
        url: '/lead',
        abstract: true,
        templateUrl: '/angular/views/lead/layout.view.html'
      })
      .state('lead.index', {
        url: '',
        templateUrl: '/angular/views/lead/index.view.html',
        roles: ['user', 'trader']
  	  })

      //browse page
  	  .state('lead.buyer', {
        url: '/buyer',
        templateUrl: '/angular/views/lead/buyer/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.seller', {
        url: '/seller',
        templateUrl: '/angular/views/lead/seller/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.vendor', {
        url: '/vendor',
        templateUrl: '/angular/views/lead/vendor/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.contact', {
        url: '/contact',
        templateUrl: '/angular/views/lead/contact/index.view.html',
        roles: ['user', 'trader']
      })



      .state('lead.search', {
        url: '/search/{searchType}/{keyword}',
        templateUrl: '/angular/views/lead/search.view.html',
        roles: ['user', 'trader']
      })
  	  .state('lead.view', {
        url: '/{type}/{id}',
        templateUrl: '/angular/views/lead/view-lead.view.html',
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
