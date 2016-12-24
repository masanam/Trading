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

    $scope.declined = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/bizdev/views/iup/declined.modal.html',
        windowClass: 'xl-modal',
        controller: 'IupModalController'
      });
    };

    $scope.items = [];

    // Add a Item to the list
    $scope.addItem = function () {

      $scope.items.push({
        amount: $scope.itemAmount,
        name: $scope.itemName
      });
    };

    // Add Item to Checked List and delete from Unchecked List
    $scope.toggleChecked = function (item, index) {
      $scope.items.splice(index, 1);
    };

    $scope.maps = [
        { name:'Jani',type:'Road' },
        { name:'Hege',type:'River' },
        { name:'Jani',type:'HTI' },
        { name:'Hege',type:'HPH' }
    ];

  }
]);