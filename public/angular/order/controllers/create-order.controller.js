'use strict';

angular.module('order').controller('CreateOrderController', ['$scope', '$state', '$uibModal', 'Environment', 'Order',
  function($scope, $state, $uibModal, Environment, Order) {
    $scope.init = function (){
      $scope.order = {};
      $scope.order.buys = [];
      $scope.order.sells = [];
      $scope.display = {};

      if(Environment.trx === 'sell') $scope.order.in_house = true;
    };

    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;
      // Create new Article object
      var order = new Order($scope.order);

      // Redirect after save
      order.$save(function (res) {
        $state.go('order.view', { id: res.id });

        // // Clear form fields
        $scope.error = undefined;
        $scope.order = new Order();
      }, function (err) {
        $scope.error = err.data.message;
      });
    };
  }
]);
