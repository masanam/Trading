'use strict';

angular.module('index').directive('sparkLineChart', function () {
  return {
    restrict: 'E',
    scope: {
      data: '='
    },
    link: function (scope, iElement, iAttrs) {
      scope.display = [];
      scope.min = 99999;
      scope.max = 0;
      var x;

      for(x=0;x<scope.data.length; x++){
        if(scope.data[x] > scope.max) scope.max = scope.data[x];
        if(scope.data[x] < scope.min) scope.min = scope.data[x];
      }

      for(x=0;x<scope.data.length; x++){
        scope.display[x] = (scope.max - scope.data[scope.data.length-x-1]) / (scope.max - scope.min) * 100;
      }
    },
    templateUrl: './angular/dashboard/directives/spark-line-chart.directive.html'
  };
});
