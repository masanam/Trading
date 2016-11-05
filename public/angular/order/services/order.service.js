'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:orderId', {
      orderId: '@id',
    }, {
      update: { method: 'PUT' }
    });
  }
]);