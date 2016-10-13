'use strict';

angular.module('order').controller('SellOrderController', ['$scope', '$uibModal', '$stateParams', 'Order',
  function($scope, $uibModal, $stateParams, Order) {
    
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
  }
]);