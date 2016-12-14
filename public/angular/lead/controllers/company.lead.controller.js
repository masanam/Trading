'use strict';

angular.module('lead').controller('CompanyLeadController', ['$scope', '$stateParams', '$location', '$uibModal', 'Company', 'Lead', 'NgMap',
  function ($scope, $stateParams, $location, $uibModal, Company, Lead, NgMap) {

    $scope.init = function(){
      $scope.company = {};
      $scope.id = $stateParams.id;
      $scope.lead_type=$location.search().lead_type;

      //lead from back button
      if ($scope.id!==null) {
        Lead.get({ id: $scope.id }, function(res){
          if (res.lead_type==='b') $scope.lead_type = 'buy';
          else if (res.lead_type==='s') $scope.lead_type = 'sell';
          $scope.findCompanies();
        });
      }
    };

    //Init select companies
    $scope.findCompanies = function() {
      if ($scope.lead_type==='buy') $scope.query_type = 's';
      else if ($scope.lead_type==='sell') $scope.query_type = 'c';
      $scope.companies = Company.query({ 'type[]': [$scope.query_type] });
    };

    //button next to concession page
    $scope.nextToOperation = function(id){
      $scope.lead = id ;
      //new lead
      if ($scope.lead.id===undefined) {
        $scope.lead = new Lead({
          company_id: $scope.company.selected.id
        });
        $scope.lead.$save({ lead_type: $scope.lead_type }, function(res) {
          $location.search('lead_type', null);
          $location.path('lead/'+res.id+'/operation');
        });
      }
      //lead from back
      else if ($scope.lead.id) {
        $scope.lead = new Lead({
          company_id: $scope.company.selected.id,
          order_status: 1 
        });
        $scope.lead.$update({ lead_type: $scope.lead_type, id: $stateParams.id }, function(res) {
          $location.search('lead_type', null);
          $location.path('lead/'+res.id+'/operation');
        });
      }
    };

    //open modal create supplier
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/company.modal.html',
        controller: 'CompanyLeadModalController',
        scope: $scope
      });
    };

  }
]);