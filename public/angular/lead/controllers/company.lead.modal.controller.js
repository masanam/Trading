'use strict';

angular.module('lead').controller('CompanyLeadModalController', function ($scope, $stateParams, $uibModalInstance, Company, Term, Lead, $location) {
  
  $scope.term = Term;

  //show freetext payment terms
  $scope.freetext = function() {
    if($scope.company.preferred_payment_term === 'other'){
      $scope.company.preferred_payment_term = '';
      $scope.company.freetext = true;
    }else{
      $scope.company.freetext = false;
    }
  };

  //creating a company
  $scope.create = function() {
    if ($scope.lead_type==='buy') $scope.query_type = 's';
    else if ($scope.lead_type==='sell') $scope.query_type = 'c';
    var company = new Company($scope.company);

    company.$save(function(res) {

      //go to step concession
      $scope.lead = new Lead({
        company_id: res.id,
        order_status: 1
      });

      //go to step concession from existing lead / back button
      if ($stateParams.id) {
        $scope.lead.$update({ type: $scope.lead_type, id: $stateParams.id }, function(res) {
          $location.path(res.id+'/concession');
          $uibModalInstance.close('success');
        });
      }
      //go to step concession new lead
      else{
        $scope.lead.$save({ type: $scope.lead_type }, function(res) {
          $location.path(res.id+'/concession');
          $uibModalInstance.close('success');
        });
      }
        
    });
  };

  //closing modal
  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});