'use strict';

angular.module('vendor').factory('Vendor', ['$resource',
  function ($resource) {
    return $resource('api/vendor/:id/:action/:status/:search', {
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