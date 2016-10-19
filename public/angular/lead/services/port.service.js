'use strict';

angular.module('port').factory('Port', ['$resource',
  function ($resource) {
    return $resource('api/port/:type/:action/:id', {
      id: undefined,
      type: undefined,
      action: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);