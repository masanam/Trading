'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:type/:id', {
      type: undefined,
      id: '@id',
    }, {
      update: { method: 'PUT' }
    });
  }
]);