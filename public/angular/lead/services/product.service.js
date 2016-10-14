'use strict';

angular.module('product').factory('Product', ['$resource',
  function ($resource) {
    return $resource('api/:option/:mineId/:sellerId/product/:id/:action', {
      option: undefined,
      mineId: undefined,
      sellerId: undefined,
      id: undefined,
      action: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);