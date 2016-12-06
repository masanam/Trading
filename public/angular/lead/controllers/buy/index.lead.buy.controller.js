'use strict';

angular.module('lead').controller('IndexLeadBuyController', ['$scope', '$location', 'Order', 'Lead',
  function($scope, $location, Order, Lead) {

    $scope.init = function(){
      // $scope.sum = 0;
      // for (var i = res.order_detail.length - 1; i >= 0; i--) {
      //   $scope.sum = $scope.sum + res.order_detail[i].volume;
      // }
    };
    
    $scope.findStatus = function($order_status) {
      $scope.sell_orders = Lead.query({ type: 'buy', order_status: $order_status });
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