'use strict';

angular.module('coalpedia').controller('CompanyModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Company', 'Term', 'company',
  function($scope, $uibModalInstance, $timeout, $interval, Company, Term, company) {
    $scope.selected = {};
    $scope.term = Term;

    $scope.create = function() {
      $scope.loading = true;
      var company = new Company($scope.company);

      company.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
