'use strict';

angular.module('lead').controller('LeadCompanyController', ['$scope', '$stateParams', '$uibModal', 'Company', 'Lead',
  function ($scope, $stateParams, $uibModal, Company, Lead) {
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

    $scope.add = function () {
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

    $scope.select = function (company) {
      if(company){
        $scope.lead.company_id = company.id;
        if(!$scope.lead.trading_term) $scope.lead.trading_term = company.preferred_trading_term;
        if(!$scope.lead.payment_term) $scope.lead.payment_term = company.preferred_payment_term;
      } else {
        if(!isNaN($scope.lead.order_status)) $scope.lead.company_id = undefined;
        else {
          $scope.selected.company = $scope.lead.company;
          alert('You can only edit company in draft leads');
        }
      }
    };
  }
]);