'use strict';
angular.module('sales').controller('SalesController', ['$scope', '$stateParams', '$state','$uibModal', 
  function($scope, $stateParams, $state, $uibModal) {

    $scope.opendetailModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/sales/modal.view.detail.html',
        controller: 'SalesModalController',
        scope: $scope,
      });
    };

    $scope.openaddveselModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/coaltradephase2/views/sales/add_vesel.html',
        controller: 'SalesModalController',
        scope: $scope,
      });
    };
  }
]);
