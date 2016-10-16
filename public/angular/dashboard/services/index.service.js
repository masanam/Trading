'use strict';

angular.module('dashboard').factory('Index', ['$resource',
  function ($resource) {
    return $resource('api/index/:indexId', {}, {
      update: {
        method: 'PUT'
      }
    });
  }
]);