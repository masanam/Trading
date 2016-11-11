'use strict';

angular.module('order').controller('UpdateSellOrderController', ['$scope', '$stateParams', '$location', 'Order',
  function($scope, $stateParams, $location, Order) {
   
    $scope.findOne = function(id) {

      $scope.freetext = false;
      if(id !== undefined){
        $scope.sell_orderId = id;
      } else {
        $scope.sell_orderId = $stateParams.id;
      }

      Order.get({ type: 'sell', id: $scope.sell_orderId }, function(res){
        res.order_date = new Date(res.order_date);
        res.order_deadline = new Date(res.order_deadline);
        res.ready_date = new Date(res.ready_date);
        res.expired_date = new Date(res.expired_date);
        res.port_latitude = parseFloat(res.port_latitude);
        res.port_longitude = parseFloat(res.port_longitude);
        $scope.sell_order = res;
      });
    };

    $scope.update = function() {
      $scope.sell_order.$update({ type: 'sell', id: $scope.sell_orderId }, function(res) {
        $location.path('sell-order/'+$scope.sell_orderId);
      });
    };

    $scope.changeOrderStatus = function(sell_order, order_status) {
      $scope.sell_orders.splice($scope.sell_orders.indexOf(sell_order), 1);
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: order_status });
    };
    
  }
]);