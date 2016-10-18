'use strict';
angular.module('order').controller('OrderHistoryController', ['$scope', 'Order',
  function($scope, Order) {
    
    $scope.findAvailableBuy = function() {
      $scope.orders = Order.query({ type: 'buy', action: 'status', order_status: 'o' });
      $scope.aktifAB = 'active';
      $scope.aktifFB = '';
      $scope.aktifAS = '';
      $scope.aktifFS = '';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
    };
    
    $scope.findStagedBuy = function() {
      $scope.orders = Order.query({ type: 'buy', action: 'status', order_status: 's' });
    };
    $scope.findFinishedBuy = function() {
      $scope.orders = Order.query({ type: 'buy', action: 'status', order_status: 'f' });
      $scope.aktifAB = '';
      $scope.aktifFB = 'active';
      $scope.aktifAS = '';
      $scope.aktifFS = '';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
    };
    $scope.findCancelledBuy = function() {
      $scope.orders = Order.query({ type: 'buy', action: 'status', order_status: 'x' });
    };
    $scope.findAvailableSell = function() {
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 'o' });$scope.aktifAB = '';
      $scope.aktifFB = '';
      $scope.aktifAS = 'active';
      $scope.aktifFS = '';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
    };
    
    $scope.findStagedSell = function() {
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 's' });
    };
    $scope.findFinishedSell = function() {
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 'f' });
      $scope.aktifFB = '';
      $scope.aktifAS = '';
      $scope.aktifFS = 'active';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
    };
    $scope.findCancelledSell = function() {
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 'x' });
    };
    $scope.changeOrderStatusA = function(buy_order) {
      $scope.buy_orders.splice($scope.buy_orders.indexOf(buy_order), 1);
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: 'a' });
    };
    $scope.changeOrderStatusF = function(buy_order) {
      $scope.buy_orders.splice($scope.buy_orders.indexOf(buy_order), 1);
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: 'f' });
    };
    $scope.changeOrderStatusC = function(buy_order) {
      $scope.buy_orders.splice($scope.buy_orders.indexOf(buy_order), 1);
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: 'x' });
    };
  }
]);