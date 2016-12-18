'use strict';

angular.module('order').controller('AddCostModalController', ['$uibModalInstance', '$scope', 'Order', 'Notification',
  function($uibModalInstance, $scope, Order, Notification) {

    if ($scope.order.additional === 'buy') {
      $scope.additional = new Order($scope.order.sells[$scope.order.index].additional);
    }else if ($scope.order.additional === 'sell') {
      $scope.additional = new Order($scope.order.buys[$scope.order.index].additional);
      
    }

    $scope.ok = function () {
      if ($scope.order.additional === 'buy') {
        $scope.order.sells[$scope.order.index].additional = $scope.additional;
        $uibModalInstance.close($scope.order.sells[$scope.order.index].additional);
      }else if ($scope.order.additional === 'sell') {
        $scope.order.buys[$scope.order.index].additional = $scope.additional;
        $uibModalInstance.close($scope.order.buys[$scope.order.index].additional);
      }
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);