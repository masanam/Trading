'use strict';

angular.module('factory').factory('Factory', ['$resource',
  function ($resource) {
    return $resource('api/factory/:id', {
      id: '@id'
    }, {
      update: {
        method: 'PUT'
      }
    });
  }
]);

angular.module('factory').factory('MultiStepForm', ['$resource',
  function ($resource) {
    return {
      tempFactoryId : undefined,
      tempConcessionId : undefined,
    };
  }
]);