'use strict';

angular.module('index').factory('News', ['$resource',
  function ($resource) {
    return $resource('api/news');
  }
]);