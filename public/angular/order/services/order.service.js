'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:id', {
      id: undefined,
    }, {
      update: { method: 'PUT' }
    });
  }
]);