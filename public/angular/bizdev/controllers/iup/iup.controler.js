'use strict';

angular.module('bizdev').controller('IupController', ['$scope', '$stateParams', 'Authentication', '$location','$uibModal', 
  function($scope, $stateParams, Authentication, $location, $uibModal) {

    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/bizdev/views/iup/create.modal.view.html',
        windowClass: 'xl-modal',
        controller: 'IupModalController'
      });
    };

    $scope.addMap = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/bizdev/views/map/create.modal.html',
        windowClass: 'xl-modal',
        controller: 'IupModalController'
      });
    };

    $scope.approved = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/bizdev/views/iup/approved.modal.html',
        windowClass: 'xl-modal',
        controller: 'IupModalController'
      });
    };

    $scope.decline = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/bizdev/views/iup/declined.modal.html',
        windowClass: 'xl-modal',
        controller: 'IupModalController'
      });
    };

  }
]);