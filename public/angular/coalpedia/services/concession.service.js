'use strict';

angular.module('concession').factory('Concession', ['$resource',
  function ($resource) {
    return $resource('api/concession/:id/:option', {
      id: '@id',
      option: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);