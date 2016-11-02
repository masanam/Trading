'use strict';

angular.module('order').controller('BuyOrderController', ['$scope', '$stateParams', '$location', 'Order',
  function($scope, $stateParams, $location, Order) {
    
    $scope.findBuyOrder = function() {
      $scope.buy_orders = Order.query({ type: 'buy' });
    };

    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.buy_orderId = id;
      } else {
        $scope.buy_orderId = $stateParams.id;
      }

      $scope.buy_order = Order.get({ type: 'buy', id: $scope.buy_orderId });
    };

    $scope.toProduct = function(buyer_id,id,factory_id) {
      $location.path('buy-order/create/product/'+buyer_id+'/'+id+'/'+factory_id);
    };

    $scope.toPort = function(buyer_id,id,factory_id) {
      $location.path('buy-order/create/port/'+buyer_id+'/'+id+'/'+factory_id);
    };
  }
]);