'use strict';

angular.module('map').factory('Map', ['$resource',
  function ($resource) {
    //return $resource('api/concession/:action', {}, {});
    return $resource('api/concession/:action', {}, {});
  }
]);
