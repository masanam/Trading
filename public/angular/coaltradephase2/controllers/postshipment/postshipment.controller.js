'use strict';

angular.module('postshipment').controller('PostshipmentController', ['$scope', '$stateParams', '$state', '$uibModal',
  function ($scope, $stateParams, $state, $uibModal) {

    $scope.openTodo = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'lg-modal',
        templateUrl: './angular/coaltradephase2/views/postshipment/todo.view.html',
        controller: 'PostshipmentModalController',
        scope: $scope,
      });
    };

  }
]);
