'use strict';

angular.module('lead').factory('Lead', ['$resource',
  function ($resource) {
    return $resource('api/leads/:id/', {
      id: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);