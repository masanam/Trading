'use strict';

angular.module('factory').controller('UpdateFactoryModalController',
  function($scope, $stateParams, $uibModalInstance, $location, Factory, Port) {

    $scope.init = function () {
      $scope.factory = new Factory($scope.factory);
      $scope.factory.latitude = parseFloat($scope.factory.latitude);
      $scope.factory.longitude = parseFloat($scope.factory.longitude);
      $scope.factory.port_distance = parseFloat($scope.factory.port_distance);
      $scope.ports = Port.query();
    };
    
    $scope.update = function() {
      $scope.factory.$update({ id: $scope.factoryId }, function(response) {
        $uibModalInstance.close('success');
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
