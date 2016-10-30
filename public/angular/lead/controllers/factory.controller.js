'use strict';

angular.module('factory').controller('FactoryController', ['$scope', '$stateParams', '$location', '$uibModal', 'Factory',
  function($scope, $stateParams, $location, $uibModal, Factory) {
    $scope.factorys = [];
    $scope.factory = {};
    $scope.new = $location.search().new;

    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/factory/modal.view.html',
        controller: 'FactoryModalController',
        scope: $scope
      });
    };

    $scope.nextToProduct = function(){
      $location.path('lead/buyer/'+$stateParams.id+'/setup-product');
    };
    
  }
]);
