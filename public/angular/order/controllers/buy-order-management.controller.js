'use strict';

angular.module('order').controller('BuyOrderManagementController', ['$location', '$scope', '$http', '$uibModal', '$stateParams', '$state', 'Order', 'Seller', '$rootScope',
  function($location, $scope, $http, $uibModal, $stateParams, $state, Order, Seller, $rootScope) {
    
    $scope.findAvailable = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'a' });
    };

    $scope.findFinished = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'f' });
    };

    $scope.findCancelled = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'x' });
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
}]);