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

      $scope.buy_order = Order.get({ type: 'buy', id: $scope.buy_orderId }, function(res){
        res.port_latitude = parseFloat(res.port_latitude);
        res.port_longitude = parseFloat(res.port_longitude);
        $scope.sum = 0;
        for (var i = res.orders.length - 1; i >= 0; i--) {
          $scope.sum = $scope.sum + res.orders[i].volume;
        }
        $scope.buy_order = res;
      });
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