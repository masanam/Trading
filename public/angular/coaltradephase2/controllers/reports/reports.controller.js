'use strict';

angular.module('reports').controller('ReportsController', ['$scope', '$stateParams', '$state', 
  function($scope, $stateParams, $state) {

    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };

    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];
    
  }
]);
 