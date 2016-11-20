'use strict';

angular.module('order').controller('FactoryModalBuyOrderController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Factory, Order) {

    $scope.init = function () {
      $scope.factory = new Factory();
    };

    var map;
    $scope.$on('mapInitialized', function(evt, evtMap) {
      map = evtMap;
      $scope.markerMove = function(e) {
        $scope.factory.latitude = e.latLng.lat();
        $scope.factory.longitude = e.latLng.lng();
      };
    });

    $scope.create = function(){
      $scope.factory.buyer_id = $stateParams.id;
      
      $scope.factory.$save(function (res) {
        $scope.factory_id = res.id;
        $scope.order = new Order({
          buyer_id: $stateParams.id,
          factory_id: res.id,
          address: res.address,
          city: res.city,
          country: res.country,
          latitude: res.latitude,
          longitude: res.longitude,
          order_status: 2
        });
        $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
          $location.path('buy-order/create/product/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$scope.factory_id);
          $uibModalInstance.close('success');
        });
      });
      
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
