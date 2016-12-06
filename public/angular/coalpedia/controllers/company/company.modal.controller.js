'use strict';

angular.module('coalpedia').controller('CompanyModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Company', 'Term', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Company, Term, company) {
    $scope.company = company;
    $scope.selected = {};
    $scope.term = Term;

    $scope.create = function() {
      var company = new Company($scope.company);

      company.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      var company = $scope.company;

      company.$update(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);