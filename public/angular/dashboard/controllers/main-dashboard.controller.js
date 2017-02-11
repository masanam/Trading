'use strict';

angular.module('dashboard').controller('MainDashboardController', ['$scope', '$stateParams', '$state', '$filter', 'Index', 'Environment',
  function($scope, $stateParams, $state, $filter, Index, Environment) {
    
    $scope.getIndices = function () {
      $scope.date = new Date();
      $scope.indexPage = 0;
      $scope.indices = Index.query({ action: 'single-date' });
    };

    $scope.labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    $scope.series = ['Series A', 'Series B'];
    $scope.data = [
      [65, 59, 80, 81, 56, 55, 40],
      [28, 48, 40, 19, 86, 27, 90]
    ];


    $scope.ConnectionFlowByMonths = [12,13,14,12,13,14,13,12,12,3,18];
  }
]);
