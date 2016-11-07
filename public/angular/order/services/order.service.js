'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:type/:id/:status/:action/:order_status/:progress_status/', {
      type: undefined,
      id: '@id',
      status: undefined,
      action: undefined,
      order_status: undefined,
      progress_status: undefined,
    }, {
      update: { method: 'PUT' }
    });
  }
]);