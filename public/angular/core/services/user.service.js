'use strict';

angular.module('user').factory('User', ['$resource',
  function ($resource) {
    return $resource('api/user/:action/:email/:id', {
      action: undefined,
      email: undefined,
      id: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);