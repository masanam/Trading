'use strict';

// Setting up route
angular.module('coalpedia').config(['$stateProvider',
  function ($stateProvider) {
    // Home state routing
    $stateProvider
      .state('company', {
        url: '/coalpedia/company/:type',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/search.layout.html'
      })
      .state('company.list', {
        url: '?keyword',
        templateUrl: '/angular/coalpedia/views/company/list.view.html',
        privileges: ['coalpedia.view', 'coalpedia.edit']
      })
      .state('company.create', {
        url: '/create',
        templateUrl: '/angular/coalpedia/views/company/wizard/create.view.html',
        privileges: ['coalpedia.edit']
      })
      .state('company.view', {
        url: '/:id',
        views: { '@': { templateUrl: '/angular/coalpedia/views/company/view.view.html' } },
        privileges: ['coalpedia.edit']
      })

      //Wizard states
      .state('company.wizard', {
        url: '/:id',
        abstract: true,
        templateUrl: '/angular/coalpedia/views/company/wizard/multistep.layout.html',
      })
      .state('company.wizard.connection', {
        url: '/connection',
        templateUrl: '/angular/coalpedia/views/company/wizard/connection.view.html',
        privileges: ['coalpedia.edit']
      })
      .state('company.wizard.operation', {
        url: '/operation',
        templateUrl: '/angular/coalpedia/views/company/wizard/operation.view.html',
        privileges: ['coalpedia.edit']
      })
      .state('company.wizard.product', {
        url: '/product',
        templateUrl: '/angular/coalpedia/views/company/wizard/product.view.html',
        privileges: ['coalpedia.edit']
      });
  }
]);
