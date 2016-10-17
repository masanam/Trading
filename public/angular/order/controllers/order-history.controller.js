'use strict';

angular.module('order').controller('OrderHistoryController', ['$scope', 'Order',
  function($scope, Order) {
    
    $scope.findAvailableBuy = function() {
      $scope.orders = Order.query({ type: 'buy', action: 'status', order_status: 'a' });
      $scope.aktifAB = 'active';
      $scope.aktifFB = '';
      $scope.aktifAS = '';
      $scope.aktifFS = '';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
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
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 'a' });
      $scope.aktifAB = '';
      $scope.aktifFB = '';
      $scope.aktifAS = 'active';
      $scope.aktifFS = '';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
    };

    $scope.findFinishedSell = function() {
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 'f' });
      $scope.aktifAB = '';
      $scope.aktifFB = '';
      $scope.aktifAS = '';
      $scope.aktifFS = 'active';
      $scope.aktifMBO = '';
      $scope.aktifMSO = '';
    };

    $scope.findCancelledSell = function() {
      $scope.orders = Order.query({ type: 'sell', action: 'status', order_status: 'x' });
    };

  }
]);