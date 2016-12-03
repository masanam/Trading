'use strict';

angular.module('coalpedia').controller('CompanyController', ['$scope', '$stateParams', '$state', '$uibModal', 'Company',
  function($scope, $stateParams, $state, $uibModal, Company) {
    $scope.selected = {};

    $scope.find = function() {
      $scope.companies = Company.query({ q: $stateParams.keyword, type:$scope.searchType });
    };

    $scope.findOne = function(id) {
      if(id !== undefined){
        $scope.companyId = id;
      } else {
        $scope.companyId = $stateParams.id;
      }

      $scope.company = Company.get({ id: $scope.companyId });
    };

    $scope.modalCreate = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/company/_create.modal.view.html',
        controller: 'CompanyModalController',
        windowClass: 'xl-modal',
        resolve: {
          company: new Company()
        }
      });

      modalInstance.result.then(function (company) {
        $scope.selected.company = company;
      }, function () {
        $scope.selected.company = undefined;
      });
    };

    $scope.modalUpdate = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/company/_update.modal.view.html',
        controller: 'CompanyModalController',
        windowClass: 'xl-modal',
        resolve: {
          company: $scope.findOne($scope.company.id)
        }
      });

      modalInstance.result.then(function (company) {
        $scope.selected.company = company;
      });
    };
  }
]);
