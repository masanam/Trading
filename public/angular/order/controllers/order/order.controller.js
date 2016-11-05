'use strict';

angular.module('order').controller('OrderController', ['$scope', '$stateParams', '$state', 'Order',
  function($scope, $stateParams, $state, Order) {
    $scope.browse = {};

    $scope.$watchGroup(['browse.status', 'browse.possession'], function() { $scope.find(); });

    // Create new Article
    $scope.create = function (isValid) {
      $scope.error = null;

      // Create new Article object
      var order = new Order($scope.order);

      // Redirect after save
      order.$save(function (res) {
        $state.go('order.view', { orderId: res.id });

        // Clear form fields
        $scope.order = new Order();
      }, function (err) {
        $scope.error = err;
      });
    };

    // Remove existing Article
    $scope.remove = function (order) {
      if (order) {
        order.$remove();

        for (var i in $scope.indices) {
          if ($scope.indices[i] === order) {
            $scope.indices.splice(i, 1);
          }
        }
      } else {
        $scope.order.$remove(function () {
          $state.go('order.list');
        });
      }
    };

    // Update existing Article
    $scope.update = function (isValid) {
      $scope.error = null;

      var order = $scope.order;

      order.$update(function (res) {
        $state.go('order.view', { orderId: res.id });
      }, function (err) {
        $scope.error = err.data.message;
      });
    };

    // Find list of order
    $scope.find = function () {
      $scope.orders = Order.query({ browse: $scope.browse });
    };

    // Find existing order
    $scope.findOne = function () {
      $scope.order = Order.get({
        orderId: $stateParams.id
      });
    };
  }
]);

