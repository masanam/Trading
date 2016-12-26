'use strict';

angular.module('preshipment').controller('PreshipmentModalController', ['$scope','$uibModalInstance','$timeout','$interval',
  function($scope, $uibModalInstance,$timeout, $interval) {
    
    $scope.display = {};

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };

  }  
]);
