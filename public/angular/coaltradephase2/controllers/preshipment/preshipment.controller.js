'use strict';

angular.module('preshipment').controller('PreshipmentController', ['$scope', '$stateParams', '$state', '$uibModal',
  function ($scope, $stateParams, $state, $uibModal) {

    $scope.openTodo = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/preshipment/todo.view.html',
        controller: 'PreshipmentModalController',
        scope: $scope,
      });
    };

  }
]);
