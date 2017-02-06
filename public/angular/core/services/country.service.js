'use strict';

angular.module('index').factory('Country', ['$resource',
  function ($resource) {
    return $resource('api/country/:id', {
      id: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);