'use strict';
angular.module('index').factory('Exchange_rate', ['$resource',
  function ($resource){
    return $resource('api/exchange-rate/:buy/:sell', {
      id: '@id'
    }, {
      update: { method: 'PUT' },
      post: { method: 'POST' },
    });
  }
]);