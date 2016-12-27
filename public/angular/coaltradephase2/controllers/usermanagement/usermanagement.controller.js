'use strict';

angular.module('usermanagement').controller('UserManagementController', ['$scope', '$stateParams', '$state','$uibModal', 
  function($scope, $stateParams, $state, $uibModal) {
    $scope.openNew = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/usermanagement/create.modal.view.html',
        controller: 'UserManagementModalController',
        scope: $scope,
      });
    }; 
  }
]);
