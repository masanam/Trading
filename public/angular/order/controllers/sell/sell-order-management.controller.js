'use strict';

angular.module('order').controller('SellOrderManagementController', ['$scope', 'Order',
  function($scope, Order) {
    
    $scope.findAvailable = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'o' });
    };

    $scope.findFinished = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'f' });
    };

    $scope.findDeleted = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'x' });
    };
    
    $scope.findCancelled = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'c' });
    };

    $scope.findStaged = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 's' });
    };

    $scope.changeOrderStatus = function(sell_order, order_status) {
      $scope.sell_orders.splice($scope.sell_orders.indexOf(sell_order), 1);
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: order_status });
    };

  }
]);