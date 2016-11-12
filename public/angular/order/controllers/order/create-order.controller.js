'use strict';

angular.module('order').controller('CreateOrderController', ['$scope', '$state', 'Order',
  function($scope, $state, Order) {
    $scope.init = function (){
      $scope.order = new Order();
      $scope.order.buys = $scope.order.sells = [];
      console.log('create order', $scope.order);
    };

    $scope.submit = function () {
      console.log($scope.order);
    };
  }
]);