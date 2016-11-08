'use strict';

angular.module('factory').controller('CustomerFactoryModalController',
  function($scope, $stateParams, $uibModalInstance, $location, Factory, Port) {

    $scope.findMyPortsBuyer = function(){
      $scope.ports = Port.query({ type: 'buyer', action: 'allMy', id: $stateParams.id });
      console.log($scope.ports);
    };

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
