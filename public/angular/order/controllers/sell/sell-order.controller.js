'use strict';

angular.module('order').controller('SellOrderController', ['$scope', '$uibModal', '$stateParams', '$location', 'Order', 'NgMap',
  function($scope, $uibModal, $stateParams, $location, Order, NgMap) {
    
    $scope.findSellOrder = function() {
      $scope.sell_orders = Order.query({ type: 'sell' });
    };

    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.sell_orderId = id;
      } else {
        $scope.sell_orderId = $stateParams.id;
      }

      $scope.sell_order = Order.get({ type: 'sell', id: $scope.sell_orderId }, function(res){
        res.port_latitude = parseFloat(res.port_latitude);
        res.port_longitude = parseFloat(res.port_longitude);
        $scope.sum = 0;
        for (var i = res.orders.length - 1; i >= 0; i--) {
          $scope.sum = $scope.sum + res.orders[i].volume;
        }
        $scope.sell_order = res;
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

    $scope.changeOrderStatusAtDetail = function(sell_order, order_status) {
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: order_status });
      $location.path('sell-order');
    };
  }
]);