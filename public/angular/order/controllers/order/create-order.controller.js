'use strict';

angular.module('order').controller('CreateOrderController', ['$scope', '$state', 'Order',
  function($scope, $state, Order) {
    $scope.init = function (){
      $scope.order = new Order();
      $scope.order.buys = [];
      $scope.order.sells = [];
      $scope.display = {};
    };

    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;

      // Create new Article object
      var order = new Order($scope.order);

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