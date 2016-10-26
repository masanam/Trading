'use strict';

angular.module('port').factory('Port', ['$resource',
  function ($resource) {
    return $resource('api/port/:type/:action/:id/:concession/:status', {
      id: undefined,
      type: undefined,
      action: undefined,
      concession: undefined,
      status: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);