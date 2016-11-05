'use strict';

angular.module('order').controller('OrderController', ['$scope', '$stateParams', '$state', 'Order',
  function($scope, $stateParams, $state, Order) {
    $scope.browse = 'pending';

    // Find list of Index
    $scope.find = function () {
    	$scope.orders = Order.query({ browse: $scope.browse });
    };

    // Find existing Index
    $scope.findOne = function () {
      $scope.order = Order.get({
        id: $stateParams.id
      });
    };
  }
]);

