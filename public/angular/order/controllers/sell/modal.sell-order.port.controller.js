'use strict';

angular.module('order').controller('PortModalSellOrderController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Port, Concession, Order) {

    $scope.init = function () {
      $scope.port = new Port();
      $scope.seller_port = new Port();
      $scope.port.has_blending = 0;
      $scope.port.has_conveyor = 0;
      $scope.port.has_crusher = 0;
    };

    $scope.create = function(){
      $scope.port.seller_id = $stateParams.id;
      $scope.distance = $scope.port.distance;

      $scope.port = new Port({
        port_name: $scope.port.port_name,
        anchorage_distance: $scope.port.anchorage_distance,
        daily_discharge_rate: $scope.port.daily_discharge_rate,
        draft_height: $scope.port.draft_height,
        has_blending: $scope.port.has_blending,
        has_conveyor: $scope.port.has_conveyor,
        has_crusher: $scope.port.has_crusher,
        is_private: $scope.port.is_private,
        latitude: $scope.port.latitude,
        location: $scope.port.location,
        longitude: $scope.port.longitude,
        owner: $scope.port.owner,
        size: $scope.port.size
      });
      $scope.port.$save(function(res) {
        $scope.port = res;
        $scope.seller_port.seller_id = $stateParams.id;
        $scope.seller_port.port_id = res.id;
        $scope.seller_port.$save({ type: 'seller', action: 'store' }, function(res) {
          $scope.postCreatePorts();
          $uibModalInstance.close('success');
        });
      });
      
    };

    var map;
    $scope.$on('mapInitialized', function(evt, evtMap) {
      map = evtMap;
      $scope.markerMove = function(e) {
        $scope.port.latitude = e.latLng.lat();
        $scope.port.longitude = e.latLng.lng();
      };
    });

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
