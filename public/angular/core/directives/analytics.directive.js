'use strict';

angular.module('index').filter('directive', function() {
  return {
    restrict: 'E',
    scope: {
      rag: '=rag'
    },
    templateUrl: './angular/directives/rag.html'
  };
});