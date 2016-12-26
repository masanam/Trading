'use strict';

angular.module('treasury').controller('TreasuryController', ['$scope', '$stateParams', '$state', 
  function($scope, $stateParams, $state) {

    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };

    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];

    $scope.labels = ['2011', '2012', '2013', '2014', '2015', '2016'];
    $scope.data = [
    	[1738, 1934, 2512, 2621, 2621, 3131]
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
    
  }
]);
