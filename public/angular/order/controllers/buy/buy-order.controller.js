'use strict';

angular.module('order').controller('BuyOrderController', ['$scope', '$stateParams', '$location', '$window', 'Order', 'NgMap',
  function($scope, $stateParams, $location, $window, Order, NgMap) {
    
    $scope.findBuyOrder = function() {
      $scope.buy_orders = Order.query({ type: 'buy' });
    };

    $scope.findOne = function(id) {

      if(id !== undefined){
        $scope.buy_orderId = id;
      } else {
        $scope.buy_orderId = $stateParams.id;
      }
      $scope.recomended = [];
      $scope.sum = 0;

      $scope.buy_order = Order.get({ type: 'buy', id: $scope.buy_orderId }, function(res){
        res.port_latitude = parseFloat(res.port_latitude);
        res.port_longitude = parseFloat(res.port_longitude);
        $scope.buy_order = res;
        for (var i = 0; i < res.orders.length; i++) {
          $scope.sum = $scope.sum + res.orders[i].pivot.volume;
        }
      });
      Order.query({ type: 'sell', order: true, order_id: $scope.buy_orderId, limit:5 }, function(res){
        for (var i = 0; i < res.length; i++) {
          if(res[i].gcv_adb_min_diff <= 150 && res[i].gcv_adb_max_diff <= 150 && res[i].gcv_arb_min_diff <= 150 && res[i].gcv_arb_max_diff <= 150 && res[i].ncv_min_diff <= 150 && res[i].ncv_max_diff <= 150){
            $scope.recomended[i] = res[i];
          }
        }
      });
    };

    $scope.findRecomendedLead = function(id) {
      $scope.sell_orderId = $stateParams.id;
      $scope.recomended = [];
      Order.query({ type: 'sell', order: true, order_id: $scope.buy_orderId, limit:5 }, function(res){
        for (var i = 0; i < res.length; i++) {
          if(res[i].gcv_adb_min_diff <= 150 && res[i].gcv_adb_max_diff <= 150 && res[i].gcv_arb_min_diff <= 150 && res[i].gcv_arb_max_diff <= 150 && res[i].ncv_min_diff <= 150 && res[i].ncv_max_diff <= 150){
            $scope.recomended[i] = res[i];
          }
        }
      });
    };

    $scope.findRecomendedCustomer = function(id) {
      $scope.sell_orderId = $stateParams.id;
      $scope.recomended = [];
      Order.query({ type: 'sell', supplier: true, order_id: $scope.buy_orderId, limit:5 }, function(res){
        for (var i = 0; i < res.length; i++) {
          if(res[i].gcv_adb_min_diff <= 150 && res[i].gcv_adb_max_diff <= 150 && res[i].gcv_arb_min_diff <= 150 && res[i].gcv_arb_max_diff <= 150 && res[i].ncv_min_diff <= 150 && res[i].ncv_max_diff <= 150){
            $scope.recomended[i] = res[i];
          }
        }
      });
    };

    $scope.showInfo = function($sell_orderId){
      $window.open('http://localhost:8000/sell-order/'+$sell_orderId, '_blank');
      // var modalInstance = $uibModal.open({
      //   windowClass: 'xl-modal',
      //   templateUrl: './angular/lead/views/product/create-from-concession.view.html',
      //   controller: 'CreateProductFromConcessionController',
      //   scope: $scope
      // });
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