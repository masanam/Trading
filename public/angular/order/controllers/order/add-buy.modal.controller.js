'use strict';

angular.module('order').controller('AddBuyModalController', ['$uibModalInstance', '$scope', 'Order', 'items',
  function($uibModalInstance, $scope, Order, items) {
    $scope.items = items;
    $scope.selected = {
      item: $scope.items[0]
    };

    $scope.ok = function () {
      $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);