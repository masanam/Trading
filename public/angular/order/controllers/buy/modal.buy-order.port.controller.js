'use strict';

angular.module('order').controller('PortModalBuyOrderController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Port, Factory, Order) {

    $scope.init = function () {
      $scope.port = new Port();
      $scope.buyer_port = new Port();
      $scope.port.has_blending = 0;
      $scope.port.has_conveyor = 0;
      $scope.port.has_crusher = 0;
    };

    var map;
    $scope.$on('mapInitialized', function(evt, evtMap) {
      map = evtMap;
      $scope.markerMove = function(e) {
        $scope.port.latitude = parseFloat(e.latLng.lat());
        $scope.port.longitude = parseFloat(e.latLng.lng());
      };
    });

    $scope.create = function(){
      $scope.port.buyer_id = $stateParams.id;
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
        $scope.buyer_port.buyer_id = $stateParams.id;
        $scope.buyer_port.port_id = res.id;
        // Factory.get({ id: $stateParams.order_id }, function(res){
        //   $scope.factory = res;
        //   $scope.factory.port_id = $scope.port.id;
        //   $scope.factory.port_distance = $scope.port.distance;
        //   $scope.factory.$update({ id: $scope.factory_id });
        // });
        $scope.buyer_port.$save({ type: 'buyer', action: 'store' }, function(res) {
          $scope.postCreatePorts();
          $uibModalInstance.close('success');\
        });
      });
      
      // $scope.port.$save(function (res) {
      //   $scope.progress = 0;
      //   $scope.success = true;
      //   $scope.product = res;
      //   var stop = $interval(function() {
      //     if ($scope.progress >= 0 && $scope.progress < 100) {
      //       $scope.progress++;
      //     } else {
      //       $interval.cancel(stop);
      //       stop = undefined;
      //       Order.get({ type: 'buy', id: $stateParams.order_id }, function(res){
      //         $scope.order = res;
      //         $scope.order.buyer_id = $stateParams.id;
      //         $scope.order.volume = $scope.volume;
      //         $scope.order.order_status = 3;

      //         $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
      //           $location.path('buy-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id);
      //           $uibModalInstance.close('success');
      //         });
      //       });
      //     }
      //   }, 75);
      // });
      
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
