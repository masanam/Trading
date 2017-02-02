'use strict';

angular.module('coalpedia').controller('CompanyModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Environment','Company', 'Term', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Environment, Company, Term, company) {
    $scope.showBuy = Environment.showBuy;
    $scope.company = company;
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
