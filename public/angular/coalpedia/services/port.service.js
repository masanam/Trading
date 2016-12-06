'use strict';

angular.module('port').factory('Port', ['$resource',
  function ($resource) {
    return $resource('api/port/:id', {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);