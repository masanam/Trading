'use strict';

angular.module('reports').controller('ReportsController', ['$scope', '$stateParams', '$state', 
  function($scope, $stateParams, $state) {

    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };

    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];

    $scope.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    $scope.data = [
      [239, 123, 120, 348, 323, 345, 234, 156, 346, 234, 345, 364]
    ];
    
    $scope.options = {
      scales: {
        yAxes: [
          {
            id: 'y-axis-1',
            type: 'linear',
            display: true,
            position: 'left'
          }
        ]
      }
    };

    $scope.labels1 = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    $scope.data1 = [
      [239, 123, 120, 348, 323, 345, 234, 156, 346, 234, 345, 364]
    ];
    
    $scope.options1 = {
      scales: {
        yAxes: [
          {
            id: 'y-axis-1',
            type: 'linear',
            display: true,
            position: 'left'
          }
        ]
      }
    };

    $scope.labels2 = ['PT. Goff Wood', 'PT. Griffith', 'PT. Sherman', 'PT. Mills', 'PT. Holloway', 'PT. Jennings'];

    $scope.data2 = [
      [789, 605, 500, 489, 405, 400]
    ];
    
  }
]);
 