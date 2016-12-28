'use strict';

angular.module('usermanagement').controller('UserManagementModalController', ['$uibModalInstance', '$scope',
  function($uibModalInstance, $scope) {
  	
    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);