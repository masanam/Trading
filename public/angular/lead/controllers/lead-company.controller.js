'use strict';

angular.module('lead').controller('LeadCompanyController', ['$scope', '$stateParams', '$uibModal', 'Company', 'Lead',
  function ($scope, $stateParams, $uibModal, Company, Lead) {
    $scope.selected = {};

    $scope.$watch('selected.company', function (newValue, oldValue) {
      if(newValue) $scope.lead.company_id = newValue.id;
      else $scope.lead.company_id = undefined;
    });

    //Init select companies
    $scope.find = function(keyword, type) {
      if(!type){
        if ($scope.lead.lead_type==='buy') type = 'supplier';
        else type = 'customer';
      }

      Company.query({ q: keyword, type: type }, function(res){
        if(res.length > 0) $scope.companies = res;
      });
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
        $scope.companies.push(company);
      }, function () {
        $scope.selected.company = undefined;
      });
    };
  }
]);