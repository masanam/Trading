'use strict';

angular.module('scheduler').controller('ScheduleModalController', ['$uibModalInstance', '$scope',
  function($uibModalInstance, $scope) {

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);