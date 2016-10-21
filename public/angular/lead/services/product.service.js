'use strict';

angular.module('product').factory('Product', ['$resource',
  function ($resource) {
    return $resource('api/:option/:mineId/:sellerId/product/:id/:action/:type', {
      option: undefined,
      mineId: undefined,
      sellerId: undefined,
      id: undefined,
      action: undefined,
      type: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);