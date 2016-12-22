'use strict';

angular.module('order').controller('CreateOrderController', ['$scope', '$state', '$uibModal', 'Order',
  function($scope, $state, $uibModal, Order) {
    $scope.init = function (){
      $scope.order = {};
      $scope.order.buys = [];
      $scope.order.sells = [];
      $scope.display = {};
    };

    // Create new Article
    $scope.create = function (isValid) {
      console.log($scope.order);
      $scope.error = null;

      // Create new Article object
      var order = new Order($scope.order);

      console.log(order.additional);
      // Redirect after save
      order.$save(function (res) {
        $state.go('order.view', { id: res.id });

        // Clear form fields
        $scope.order = new Order();
      }, function (err) {
        $scope.error = err;
      });
    };
  }
]);