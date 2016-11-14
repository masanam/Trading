'use strict';

angular.module('order').controller('SellOrderIndexController', ['$scope', '$location', 'Order',
  function($scope, $location, Order) {

    $scope.init = function(){
      // $scope.sum = 0;
      // for (var i = res.order_detail.length - 1; i >= 0; i--) {
      //   $scope.sum = $scope.sum + res.order_detail[i].volume;
      // }
    }
    
    $scope.findDraft = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'draft', user_id: $scope.Authentication.user.id });
    };

    $scope.findLead = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'l' }, function(res){
        // for (var i = res.order_detail.length - 1; i >= 0; i--) {
        //   $scope.sum = $scope.sum + res.order_detail[i].volume;
        // }
      });
    };

    $scope.findVerified = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'v' });
    };
    
    $scope.findStaged = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 's' });
    };

    $scope.findPartial = function() {
      $scope.sell_orders = Order.query({ type: 'sell', action: 'status', order_status: 'p' });
    };

    $scope.findAll = function() {
      $scope.sell_orders = Order.query({ type: 'sell' });
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

  }
]);