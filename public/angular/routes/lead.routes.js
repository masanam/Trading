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
      .state('lead.product', {
        url: '/product?keyword',
        templateUrl: '/angular/views/lead/product/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.mine', {
        url: '/mine?keyword',
        templateUrl: '/angular/views/lead/mine/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.contact', {
        url: '/contact?keyword',
        templateUrl: '/angular/views/lead/contact/index.view.html',
        roles: ['user', 'trader']
      })

      //CREATE PAGES
      .state('lead.create-buyer', {
        url: '/buyer/create',
        templateUrl: '/angular/views/lead/buyer/create.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.create-seller', {
        url: '/seller/create',
        templateUrl: '/angular/views/lead/seller/create.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.create-vendor', {
        url: '/vendor/create',
        templateUrl: '/angular/views/lead/vendor/create.view.html',
        roles: ['user', 'trader']
      })

      //UPDATE PAGES
      .state('lead.update-buyer', {
        url: '/buyer/update/{id}',
        templateUrl: '/angular/views/lead/buyer/update.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.update-seller', {
        url: '/seller/update/{id}',
        templateUrl: '/angular/views/lead/seller/update.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.update-vendor', {
        url: '/vendor/update/{id}',
        templateUrl: '/angular/views/lead/vendor/update.view.html',
        roles: ['user', 'trader']
      })

      //VIEW PAGES
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
