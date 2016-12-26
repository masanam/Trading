'use strict';

angular.module('dashboard').controller('MainDashboardController', ['$scope', 'Index', 'Environment',
  function($scope, Index, Environment) {
    $scope.getIndices = function () {
      $scope.date = new Date();
      $scope.indexPage = 0;
      $scope.indices = Index.query({ action: 'single-date' });
    };

    console.log('environment', Environment);
  }
]);
