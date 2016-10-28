'use strict';

angular.module('order').controller('FactoryModalBuyOrderController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Factory, Order) {

    $scope.init = function () {
      $scope.factory = new Factory();
    };

    $scope.create = function(){
      $scope.factory.buyer_id = $stateParams.id;
      
      $scope.factory.$save(function (res) {
        $scope.progress = 0;
        $scope.success = true;
        $scope.factory_id = res.id;
        var stop = $interval(function() {
          if ($scope.progress >= 0 && $scope.progress < 100) {
            $scope.progress++;
          } else {
            $interval.cancel(stop);
            stop = undefined;
            $scope.order = new Order({
              buyer_id: $stateParams.id,
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
          }
        }, 75);
      });
      
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
