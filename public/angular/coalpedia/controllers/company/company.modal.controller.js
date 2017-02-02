'use strict';

angular.module('coalpedia').controller('CompanyModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Company', 'Term', 'company', 'companyType', 'Area',
  function($scope, $uibModalInstance, $timeout, $interval, Company, Term, company, companyType, Area) {
    $scope.company = company;
    $scope.companyType = companyType;
    $scope.selected = {};
    $scope.term = Term;

    $scope.create = function() {
      //valudation on company name
      if(!$scope.company.company_type) return alert('You must choose a company type!');

      var company = new Company($scope.company);

      company.$save({ type: company.company_type }, function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.findAreas = function(){
      $scope.areas = Area.query();
    };

    $scope.update = function() {
      var company = $scope.company;

      company.$update({ id: $scope.company.id }, function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
