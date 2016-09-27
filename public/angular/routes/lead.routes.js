'use strict';

// Setting up route
angular.module('lead').config(['$stateProvider', '$urlRouterProvider',
  function ($stateProvider, $urlRouterProvider) {
    // Home state routing
    $stateProvider
      .state('lead', {
        url: '/lead',
        abstract: true,
        template: '<ui-view/>'
      })
      .state('lead.index', {
        url: '',
        templateUrl: '/angular/views/lead/index.view.html',
        roles: ['user', 'trader']
  	  })

      //browse page
  	  .state('lead.buyer', {
        url: '/buyer?keyword',
        templateUrl: '/angular/views/lead/buyer/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.seller', {
        url: '/seller?keyword',
        templateUrl: '/angular/views/lead/seller/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.vendor', {
        url: '/vendor?keyword',
        templateUrl: '/angular/views/lead/vendor/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.contact', {
        url: '/contact?keyword',
        templateUrl: '/angular/views/lead/contact/index.view.html',
        roles: ['user', 'trader']
      })



      .state('lead.search', {
        url: '/search/{searchType}/{keyword}',
        templateUrl: '/angular/views/lead/search.view.html',
        roles: ['user', 'trader']
      })
  	  /*.state('lead.view', {
        url: '/{type}/{id}',
        templateUrl: '/angular/views/lead/view-lead.view.html',
        roles: ['user', 'trader']
      })*/
      .state('lead.view-buyer', {
        url: '/buyer/{id}',
        templateUrl: '/angular/views/lead/buyer/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-seller', {
        url: '/seller/{id}',
        templateUrl: '/angular/views/lead/seller/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-vendor', {
        url: '/vendor/{id}',
        templateUrl: '/angular/views/lead/vendor/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-contact', {
        url: '/contact/{id}',
        templateUrl: '/angular/views/lead/contact/view.view.html',
        roles: ['user']
      })
      .state('lead.create', {
        url: '/create',
        templateUrl: '/angular/views/lead/create.view.html',
        roles: ['admin']
      });
  }
]);
