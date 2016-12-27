'use strict';

angular.module('sales').controller('SalesModalController', ['$uibModalInstance', '$scope',
  function($uibModalInstance, $scope) {

  	$scope.items = [];

    // Add a Item to the list
    $scope.addItem = function () {

      $scope.items.push({
        amount: $scope.itemAmount,
        name: $scope.itemName
      });
    };

    // Add Item to Checked List and delete from Unchecked List
    $scope.toggleChecked = function (item, index) {
      $scope.items.splice(index, 1);
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);