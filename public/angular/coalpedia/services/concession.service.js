'use strict';

angular.module('concession').factory('Concession', ['$resource',
  function ($resource) {
    return $resource('api/concession/:id/:option', {
      id: undefined,
      option: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);