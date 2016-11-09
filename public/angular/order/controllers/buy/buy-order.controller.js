'use strict';

angular.module('order').controller('BuyOrderController', ['$scope', '$stateParams', '$location', 'Order', 'NgMap',
  function($scope, $stateParams, $location, Order, NgMap) {
    
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

    $scope.initCollapse = function() {
      $scope.isCollapsed2 = true;
      $scope.isCollapsed3 = false;
      $scope.isCollapsed = false;
    };

    $scope.initMap = function() {
      NgMap.getMap().then(function(map) {
        $scope.map = map;
      });
    };

    $scope.changeOrderStatusAtDetail = function(buy_order, order_status) {
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: order_status });
      $location.path('buy-order');
    };
  }
]);