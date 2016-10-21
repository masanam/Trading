'use strict';

angular.module('concession').factory('Concession', ['$resource',
  function ($resource) {
    return $resource('api/concession/:action/:id/:option', {
      action: undefined,
      sellerId: undefined,
      id: undefined,
      option: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);