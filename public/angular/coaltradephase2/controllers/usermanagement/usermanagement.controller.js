'use strict';

angular.module('usermanagement').controller('UserManagementController', ['$scope', '$stateParams', '$state', 
  function($scope, $stateParams, $state) {

    $scope.onClick = function (points, evt) {
      console.log(points, evt);
    };

    $scope.datasetOverride = [{ yAxisID: 'y-axis-1' }];
    
  }
]);
