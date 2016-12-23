'use strict';

angular.module('treasury').controller('TreasuryController', ['$scope', '$stateParams', '$state', 
  function($scope, $stateParams, $state) {

    $scope.labels = ['2011', '2012', '2013', '2014', '2015', '2016'];
    $scope.data = [
    	[28, 48, 40, 19, 86, 27, 90]
    ];

    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };

    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];
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
    
  }
]);
