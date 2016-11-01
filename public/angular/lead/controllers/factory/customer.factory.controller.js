'use strict';

angular.module('factory').controller('CustomerFactoryModalController',
  function($scope, $stateParams, $uibModalInstance, $location, Factory) {

    $scope.init = function () {
      $scope.factory = new Factory();
    };

    $scope.create = function(){
      $scope.factory.buyer_id = $stateParams.id;
      
      $scope.factory.$save(function (res) {
        $scope.buyer.factory.push(res);
        $uibModalInstance.close('success');
      });
      
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
