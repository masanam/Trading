'use strict';

angular.module('order').controller('BuyOrderIndexController', ['$scope', '$location', 'Order',
  function($scope, $location, Order) {
    
    $scope.findDraft = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'draft', user_id: $scope.Authentication.user.id });
    };

    $scope.findLead = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'l' });
    };

    $scope.findVerified = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 'v' });
    };
    
    $scope.findStaged = function() {
      $scope.buy_orders = Order.query({ type: 'buy', action: 'status', order_status: 's' });
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

  }
]);