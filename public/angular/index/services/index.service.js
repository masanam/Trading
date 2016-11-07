'use strict';

angular.module('dashboard').factory('Index', ['$resource',
  function ($resource) {
    return $resource('api/index/:action/:indexId/:submodel/:indexPriceId', {
      indexId: '@id',
    }, {
      update: { method: 'PUT' },
      post: { method: 'POST' },
    });
  }
]);