'use strict';

angular.module('order').factory('Order', ['$resource',
  function ($resource) {
    return $resource('api/order/:option/:type/:id/:action/:order_status/:progress_status/:sellerId', {
      option:undefined,
      type:undefined,
      id: undefined,
      action: undefined,
      order_status: undefined,
      progress_status: undefined,
      sellerId:undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);