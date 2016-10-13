'use strict';

angular.module('order').controller('BuyOrderController', ['$scope', '$uibModal', '$stateParams', 'Order',
  function($scope, $uibModal, $stateParams, Order) {
    
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
}]);