'use strict';

angular.module('postshipment').controller('PostshipmentModalController', ['$scope','$uibModalInstance','$timeout','$interval',
  function($scope, $uibModalInstance,$timeout, $interval) {
    
    $scope.display = {};

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };

  }  
]);
