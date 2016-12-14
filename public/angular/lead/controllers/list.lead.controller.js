'use strict';

angular.module('lead').controller('ListLeadController', ['$scope', '$location', 'Order', 'Lead',
  function($scope, $location, Order, Lead) {

    $scope.init = function(){
      $scope.lead_type=$location.search().lead_type;
    };
    
    $scope.findStatus = function($order_status, $lead_type) {
      $scope.leads = Lead.query({ lead_type: $lead_type, order_status: $order_status });
    };

    $scope.toSupplier = function(id) {
      $location.path('sell-order/create/supplier/'+id);
    };

    $scope.toConcession = function(company_id,id) {
      $location.path(id+'/concession/'+company_id);
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