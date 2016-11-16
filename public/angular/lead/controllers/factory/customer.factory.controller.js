'use strict';

angular.module('factory').controller('CustomerFactoryModalController',
  function($scope, $stateParams, $uibModalInstance, $location, Factory, Port) {

    $scope.findMyPortsBuyer = function(){
      $scope.ports = Port.query({ type: 'buyer', action: 'allMy', id: $stateParams.id });
    };

    var map;
    $scope.$on('mapInitialized', function(evt, evtMap) {
      map = evtMap;
      $scope.markerMove = function(e) {
        $scope.factory.latitude = e.latLng.lat();
        $scope.factory.longitude = e.latLng.lng();
      };
    });


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
