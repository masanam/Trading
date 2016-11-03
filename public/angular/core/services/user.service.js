'use strict';

angular.module('user').factory('User', ['$resource',
  function ($resource) {
    return $resource('api/user/:action/:actionDetail/:email/:id', {
      action: undefined,
      actionDetail: undefined,
      email: undefined,
      id: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);