'use strict';

angular.module('coalpedia').factory('Coalpedia', ['$resource',
  function ($resource) {
    return $resource('api/coalpedia/:action', { action: 'total' });
  }
]);

angular.module('coalpedia').factory('Company', ['$resource',
  function ($resource) {
    return $resource('api/company/:id/:action', {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);