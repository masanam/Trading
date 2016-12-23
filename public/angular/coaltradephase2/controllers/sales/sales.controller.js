'use strict';

angular.module('sales').controller('SalesController', ['$scope', '$stateParams', '$state', 
  function($scope, $stateParams, $state) {
    $scope.IsHidden = true;
      $scope.ShowHide = function () {
        $scope.IsHidden = $scope.IsHidden ? false : true;
      };
    
  }
]);
