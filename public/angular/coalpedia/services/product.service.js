'use strict';

angular.module('product').factory('Product', ['$resource',
  function ($resource) {
    return $resource('api/product/:id', {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);