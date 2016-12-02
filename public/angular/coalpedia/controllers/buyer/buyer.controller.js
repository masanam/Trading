'use strict';

angular.module('buyer').controller('BuyerController', ['$scope', '$stateParams', '$state', '$uibModal', 'Buyer',
  function($scope, $stateParams, $state, $uibModal, Buyer) {
    $scope.selected = {};

    $scope.find = function() {
      $scope.buyers = Buyer.query({ q: $stateParams.keyword });
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.buyerId = id;
      } else {
        $scope.buyerId = $stateParams.id;
      }

      $scope.buyer = Buyer.get({ id: $scope.buyerId });
    };

    $scope.modalCreate = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/buyer/create.modal.view.html',
        controller: 'BuyerModalController',
        scope: $scope,
      });
    };
  }
]);
