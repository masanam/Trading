'use strict';

angular.module('order').controller('SellOrderController', ['$scope', '$uibModal', '$stateParams', '$location', 'Order',
  function($scope, $uibModal, $stateParams, $location, Order) {
    
    $scope.findSellOrder = function() {
      $scope.sell_orders = Order.query({ type: 'sell' });
    };

    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.sell_orderId = id;
      } else {
        $scope.sell_orderId = $stateParams.id;
      }

      $scope.sell_order = Order.get({ type: 'sell', id: $scope.sell_orderId });
    };

    $scope.initCollapse = function() {
      $scope.isCollapsed2 = true;
      $scope.isCollapsed = false;
    };

    $scope.toSupplier = function(id) {
      $location.path('sell-order/create/supplier/'+id);
    };

    $scope.toConcession = function(seller_id,id) {
      $location.path('sell-order/create/concession/'+seller_id+'/'+id);
    };

    $scope.toProduct = function(seller_id,id,concession_id) {
      $location.path('sell-order/create/product/'+seller_id+'/'+id+'/'+concession_id);
    };

    $scope.toPort = function(seller_id,id,concession_id) {
      $location.path('sell-order/create/port/'+seller_id+'/'+id+'/'+concession_id);
    };

    $scope.toSummary = function(seller_id,id,concession_id) {
      $location.path('sell-order/create/summary/'+seller_id+'/'+id+'/'+concession_id);
    };

    $scope.changeOrderStatus = function(sell_order, order_status) {
      $scope.sell_orders.splice($scope.sell_orders.indexOf(sell_order), 1);
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: order_status });
    };

    $scope.changeOrderStatusAtDetail = function(sell_order, order_status) {
      $scope.sell_order = Order.get({ type: 'sell', id: sell_order.id, action: 'changeOrderStatus', order_status: order_status });
      $location.path('sell-order');
    };
  }
]);