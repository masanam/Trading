'use strict';

angular.module('order').controller('AddCostModalController', ['$uibModalInstance', '$scope', 'Order', 'Notification',
  function($uibModalInstance, $scope, Order, Notification) {
    $scope.order = new Order($scope.order);

    $scope.ok = function () {
      $uibModalInstance.close($scope.order);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);