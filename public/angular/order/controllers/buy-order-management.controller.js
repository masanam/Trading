'use strict';

angular.module('order').controller('BuyOrderManagementController', ['$scope', 'Order',
  function($scope, Order) {
    
    $scope.findAvailable = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'o' });
    };

    $scope.findFinished = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'f' });
    };

    $scope.findDeleted = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'x' });
    };
    
    $scope.findCancelled = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'c' });
    };

    $scope.findStaged = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 's' });
    };

    $scope.changeOrderStatus = function(buy_order, order_status) {
      $scope.buy_orders.splice($scope.buy_orders.indexOf(buy_order), 1);
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: order_status });
    };
  }
]);