'use strict';

angular.module('scheduler').controller('ScheduleModalController', ['$uibModalInstance', '$scope',
  function($uibModalInstance, $scope) {

    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);