'use strict';

angular.module('coalpedia').factory('Coalpedia', ['$resource',
  function ($resource) {
    return $resource('api/coalpedia/:action', { action: 'total' });
  }
]);