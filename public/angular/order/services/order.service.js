'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:type/:id/:action/:order_status/:progress_status/', {
      type: undefined,
      id: '@id',
      action: undefined,
      order_status: undefined,
      progress_status: undefined,
    }, {
      update: { method: 'PUT' }
    });
  }
]);