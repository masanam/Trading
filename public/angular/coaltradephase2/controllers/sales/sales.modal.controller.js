'use strict';

angular.module('sales').controller('SalesModalController', ['$uibModalInstance', '$scope',
  function($uibModalInstance, $scope) {

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);