'use strict';

angular.module('coalpedia').controller('CompanyController', ['$scope', '$stateParams', '$state', '$uibModal', 'Company',
  function($scope, $stateParams, $state, $uibModal, Company) {
    $scope.selected = {};
    $scope.companyType = $stateParams.type;
    $scope.state = $state;

    $scope.find = function(keyword) {
      if(!keyword) keyword = $stateParams.keyword;

      Company.query({ q: keyword, type:$scope.searchType }, function(res){
        if(res.length > 0) $scope.companies = res;
      });
    };

    $scope.delete = function (company) {
      if(confirm('Are you sure you want to delete ' + company.company_name + '?')){
        var deletedCompany = company;
        company = new Company(company);
        company.$remove(function (res){
          $scope.companies.splice($scope.companies.indexOf(deletedCompany), 1);
        });
      }
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
          company: new Company(),
          companyType: function (){ return $scope.companyType; }
        }
      });

      modalInstance.result.then(function (company) {
        console.log(company);
        $scope.selected.company = company;
        $scope.companies.push(company);
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
          company: Company.get({ id: $scope.company.id }),
          companyType: function (){ return $scope.companyType; }
        }
      });

      modalInstance.result.then(function (res) {
        $scope.company = res;
      });
    };
  }
]);
