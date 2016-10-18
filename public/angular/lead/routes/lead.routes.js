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
        templateUrl: '/angular/lead/views/index.view.html',
        roles: ['user', 'trader']
      })

      //browse page
      .state('lead.buyer', {
        url: '/buyer?keyword',
        templateUrl: '/angular/lead/views/buyer/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.seller', {
        url: '/seller?keyword',
        templateUrl: '/angular/lead/views/seller/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.vendor', {
        url: '/vendor?keyword',
        templateUrl: '/angular/lead/views/vendor/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.product', {
        url: '/product?keyword',
        templateUrl: '/angular/lead/views/product/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.concession', {
        url: '/concession?keyword',
        templateUrl: '/angular/lead/views/concession/index.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.contact', {
        url: '/contact?keyword',
        templateUrl: '/angular/lead/views/contact/index.view.html',
        roles: ['user', 'trader']
      })

      //CREATE PAGES
      .state('lead.create-buyer', {
        url: '/buyer/create',
        templateUrl: '/angular/lead/views/buyer/create.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.create-seller', {
        url: '/seller/create',
        templateUrl: '/angular/lead/views/seller/create.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.create-vendor', {
        url: '/vendor/create',
        templateUrl: '/angular/lead/views/vendor/create.view.html',
        roles: ['user', 'trader']
      })

      //SETUP PAGES
      .state('lead.setup-produk', {
        url: '/buyer/{id}/setup-produk',
        templateUrl: '/angular/lead/views/buyer/setup.product.view.html',
        roles: ['user', 'trader']
      })

      //UPDATE PAGES
      .state('lead.update-buyer', {
        url: '/buyer/update/{id}',
        templateUrl: '/angular/lead/views/buyer/update.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.update-seller', {
        url: '/seller/update/{id}',
        templateUrl: '/angular/lead/views/seller/update.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.update-product', {
        url: '/product/update/{id}',
        templateUrl: '/angular/lead/views/product/update.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.update-vendor', {
        url: '/vendor/update/{id}',
        templateUrl: '/angular/lead/views/vendor/update.view.html',
        roles: ['user', 'trader']
      })

      //VIEW PAGES
      /*.state('lead.view', {
        url: '/{type}/{id}',
        templateUrl: '/angular/lead/views/view-lead.view.html',
        roles: ['user', 'trader']
      })*/
      .state('lead.view-buyer', {
        url: '/buyer/{id}',
        templateUrl: '/angular/lead/views/buyer/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-seller', {
        url: '/seller/{id}',
        templateUrl: '/angular/lead/views/seller/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-vendor', {
        url: '/vendor/{id}',
        templateUrl: '/angular/lead/views/vendor/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-product', {
        url: '/product/{id}',
        templateUrl: '/angular/lead/views/product/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-concession', {
        url: '/concession/{id}',
        templateUrl: '/angular/lead/views/concession/view.view.html',
        roles: ['user', 'trader']
      })
      .state('lead.view-contact', {
        url: '/contact/{id}',
        templateUrl: '/angular/lead/views/contact/view.view.html',
        roles: ['user']
      })
      .state('lead.create', {
        url: '/create',
        templateUrl: '/angular/lead/views/create.view.html',
        roles: ['admin']
      });
  }
]);
