'use strict';

angular.module('coalpedia').controller('ConcessionController', ['$scope', '$stateParams', '$state', '$uibModal', 'Concession',
  function($scope, $stateParams, $state, $uibModal, Concession) {
    $scope.selected = {};

    $scope.find = function() {
      $scope.concessions = Concession.query({ q: $stateParams.keyword, type:$scope.searchType });
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.concessionId = id;
      } else {
        $scope.concessionId = $stateParams.id;
      }

      $scope.concession = Concession.get({ id: $scope.concessionId });
    };

    $scope.modalCreate = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/concession/_create.modal.view.html',
        controller: 'ConcessionModalController',
        windowClass: 'xl-modal',
        resolve: {
          concession: new Concession()
        }
      });

      modalInstance.result.then(function (concession) {
        $scope.selected.concession = concession;
      }, function () {
        $scope.selected.concession = undefined;
      });
    };

    $scope.modalUpdate = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/concession/_update.modal.view.html',
        controller: 'ConcessionModalController',
        windowClass: 'xl-modal',
        resolve: {
          concession: $scope.findOne($scope.concession.id)
        }
      });

      modalInstance.result.then(function (concession) {
        $scope.selected.concession = concession;
      });
    };
  }
]);
