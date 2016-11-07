'use strict';

angular.module('order').controller('BuyOrderController', ['$scope', '$stateParams', '$location', 'Order',
  function($scope, $stateParams, $location, Order) {
    
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

    $scope.toCustomer = function(id) {
      $location.path('buy-order/create/customer/'+id);
    };

    $scope.toFactory = function(buyer_id,id) {
      $location.path('buy-order/create/factory/'+buyer_id+'/'+id);
    };

    $scope.toProduct = function(buyer_id,id,factory_id) {
      $location.path('buy-order/create/product/'+buyer_id+'/'+id+'/'+factory_id);
    };

    $scope.toPort = function(buyer_id,id,factory_id) {
      $location.path('buy-order/create/port/'+buyer_id+'/'+id+'/'+factory_id);
    };

    $scope.toSummary = function(buyer_id,id,factory_id) {
      $location.path('buy-order/create/summary/'+buyer_id+'/'+id+'/'+factory_id);
    };

    $scope.changeOrderStatus = function(buy_order, order_status) {
      $scope.buy_orders.splice($scope.buy_orders.indexOf(buy_order), 1);
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: order_status });
    };

    $scope.changeOrderStatusAtDetail = function(buy_order, order_status) {
      $scope.buy_order = Order.get({ type: 'buy', id: buy_order.id, action: 'changeOrderStatus', order_status: order_status });
      $location.path('buy-order');
    };
  }
]);