'use strict';

var order = angular.module('order');

order.controller('SellOrderManagementController', ['$location', '$scope', '$http', '$uibModal', '$stateParams', '$state', 'Order', 'Seller', '$rootScope',
  function($location, $scope, $http, $uibModal, $stateParams, $state, Order, Seller, $rootScope) {
    
    $scope.findAvailable = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'a' });
    };

    $scope.findFinished = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'f' });
    };

    $scope.findCancelled = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'x' });
    };

    $scope.changeOrderStatusA = function(sell_order) {
      $scope.sell_orders.splice($scope.sell_orders.indexOf(sell_order), 1);
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: 'a' });
    };

    $scope.changeOrderStatusF = function(sell_order) {
      $scope.sell_orders.splice($scope.sell_orders.indexOf(sell_order), 1);
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: 'f' });
    };

    $scope.changeOrderStatusC = function(sell_order) {
      $scope.sell_orders.splice($scope.sell_orders.indexOf(sell_order), 1);
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: 'x' });
    };
}]);