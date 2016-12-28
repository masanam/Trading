'use strict';
angular.module('scheduler').controller('ScheduleController', ['$scope', '$stateParams', '$state','$uibModal', 
  function($scope, $stateParams, $state, $uibModal) {

    $scope.opendetailModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/scheduler/modal.view.detail.html',
        controller: 'ScheduleModalController',
        scope: $scope,
      });
    };

    $scope.openhistoryModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/scheduler/modal.history.detail.html',
        controller: 'ScheduleModalController',
        scope: $scope,
      });
    };

    $scope.openaddveselModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/sales/modal.add.vesel.html',
        controller: 'SalesModalController',
        scope: $scope,
      });
    };

  }
]);
