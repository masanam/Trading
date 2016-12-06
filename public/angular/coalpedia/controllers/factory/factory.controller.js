'use strict';

angular.module('coalpedia').controller('FactoryController', ['$scope', '$stateParams', '$state', '$uibModal', 'Factory',
  function($scope, $stateParams, $state, $uibModal, Factory) {
    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/factory/_create.modal.view.html',
        controller: 'FactoryModalController',
        windowClass: 'xl-modal',
        resolve: {
          factory: new Factory(),
          company: $scope.company
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.factories) $scope.company.factories = [];
        
        $scope.company.factories.push(res);
      });
    };

    $scope.edit = function (factory) {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/factory/_update.modal.view.html',
        controller: 'FactoryModalController',
        windowClass: 'xl-modal',
        resolve: {
          factory: Factory.get({ id: factory.id }),
          company: $scope.company
        }
      });

      modalInstance.result.then(function (res) {
        if(!$scope.company.factories) $scope.company.factories = [];
        $scope.company.factories.splice($scope.company.factories.indexOf(factory), 1, res);
      });
    };

    $scope.delete = function (factory) {
      if(confirm('Are you sure you want to delete ' + factory.name + '?')){
        factory = new Factory(factory);
        factory.$remove(function (res){
          $scope.company.factories.splice($scope.company.factories.indexOf(factory), 1);
        });
      }
    };

    $scope.findOne = function() {
      Factory.get({ id: $stateParams.id }, function(factory){
        $scope.factory = factory;

        switch(factory.company.company_type){
          case 'c' : $scope.companyType = 'customer'; break;
          case 's' : $scope.companyType = 'supplier'; break;
          case 't' : $scope.companyType = 'supplier'; break;
          case 'v' : $scope.companyType = 'vendor'; break;
        }
      });
    };
  }
]);
