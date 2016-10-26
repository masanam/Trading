'use strict';

angular.module('port').factory('Port', ['$resource',
  function ($resource) {
    return $resource('api/port/:type/:action/:id/:concession/:portId/:status', {
      id: undefined,
      type: undefined,
      action: undefined,
      concession: undefined,
      portId: undefined,
      status: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);