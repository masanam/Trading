'use strict';

angular.module('lead').factory('Lead', ['$resource',
  function ($resource) {
    return $resource('api/leads/:id/', {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);