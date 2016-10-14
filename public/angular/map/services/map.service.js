'use strict';

angular.module('map').factory('Map', ['$resource',
  function ($resource) {
    return $resource('api/concession/filter', {}, {});
  }
]);