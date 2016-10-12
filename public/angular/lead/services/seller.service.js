'use strict';

angular.module('seller').factory('Seller', ['$resource',
  function ($resource) {
    return $resource('api/seller/:id/:action/:status/:search', {
          id: undefined,
      action: undefined,
      status: undefined,
      search: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);