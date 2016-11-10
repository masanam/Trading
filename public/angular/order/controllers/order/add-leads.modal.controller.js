'use strict';

angular.module('order').controller('AddLeadsModalController', ['$uibModalInstance', '$scope', 'Order', 'items', 'lead',
  function($uibModalInstance, $scope, Order, items, lead) {
    $scope.items = items;
    $scope.lead = lead;
    $scope.selected = {
      item: $scope.items[0]
    };

    $scope.find = function () {
      console.log('focus here');
    };

    $scope.ok = function () {
      $uibModalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);