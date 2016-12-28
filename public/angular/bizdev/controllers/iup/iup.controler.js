'use strict';

angular.module('bizdev').controller('IupController', ['$scope', '$stateParams', 'Authentication', '$location','$uibModal', 'Concession',
  function($scope, $stateParams, Authentication, $location, $uibModal, Concession) {

    $scope.find = function() {
      $scope.concessions = Concession.query({ q: $stateParams.keyword, type:$scope.searchType }, function(res){
        console.log(res);
        $scope.status = ['Approve', 'Declined', 'Pending'];
        for (var i = 0; i < res.length; i++) {
          $scope.concessions[i].rand = $scope.status[Math.floor(Math.random() * $scope.status.length)];
        }
      });
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.concessionId = id;
      } else {
        $scope.concessionId = $stateParams.id;
      }

      Concession.get({ id: $scope.concessionId }, function(res){
        $scope.concession = res;
        console.log(res);
      });
    };

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
        windowClass: 'md-modal',
        controller: 'IupModalController'
      });
    };

    $scope.declined = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/bizdev/views/iup/declined.modal.html',
        windowClass: 'md-modal',
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