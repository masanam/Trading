'use strict';

angular.module('factory').controller('DetailFactoryController', ['$scope', '$stateParams', 'Factory', '$window', '$uibModal', '$state',
  function($scope, $stateParams, Factory, $window, $uibModal, $state) {

    $scope.findOne = function() {
      $scope.factoryId = $stateParams.id;
      $scope.factory = Factory.get({ id: $scope.factoryId });
    };
    
    $scope.updateModal = function (factoryId) {
      $scope.factoryId = factoryId;
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/factory/update.view.html',
        controller: 'UpdateFactoryModalController',
        scope: $scope
      });
    };
    
    $scope.goBackToBuyer = function(){
      $state.go('buyer.view', { id: $scope.factory.buyer_id });
    };

    $scope.goToUpdateFactory = function(factoryId){
      $state.go('factory.update', { id: factoryId });
    };
    
  }
]);
