'use strict';

angular.module('contact').factory('Contact', ['$resource',
  function ($resource) {
    return $resource('api/contact/:id/:action/:search', {
      id: undefined,
      action:undefined,
      search: undefined
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);