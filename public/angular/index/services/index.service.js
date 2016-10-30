'use strict';

angular.module('dashboard').factory('Index', ['$resource',
  function ($resource) {
    return $resource('api/index/:action/:indexId/:submodel/:indexPriceId', {}, {
      update: { method: 'PUT' },
      post: { method: 'POST' },
    });
  }
]);