'use strict';

angular.module('order').controller('UpdateBuyOrderController', ['$scope', '$stateParams', '$location', 'Order',
  function($scope, $stateParams, $location, Order) {
   
    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.buy_orderId = id;
      } else {
        $scope.buy_orderId = $stateParams.id;
      }

      Order.get({ type: 'buy', id: $scope.buy_orderId }, function(res){
        res.order_date = new Date(res.order_date);
        res.order_deadline = new Date(res.order_deadline);
        res.ready_date = new Date(res.ready_date);
        res.expired_date = new Date(res.expired_date);
        $scope.buy_order = res;
      });
    };

    $scope.update = function() {
      $scope.buy_order.$update({ type: 'buy', id: $scope.buy_orderId }, function(res) {
        $location.path('buy-order/'+$scope.buy_orderId);
      });
    };

    $scope.changeOrderStatus = function(buy_order, order_status) {
      $scope.buy_orders.splice($scope.buy_orders.indexOf(buy_order), 1);
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: order_status });
    };
  }
]);