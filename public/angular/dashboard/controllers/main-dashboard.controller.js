'use strict';

angular.module('dashboard').controller('MainDashboardController', ['$scope', '$stateParams', '$state', '$filter', 'Index', 'Environment',
  function($scope, $stateParams, $state, $filter, Index, Environment) {
    
    $scope.getIndices = function () {
      $scope.date = new Date();
      $scope.indexPage = 0;
      $scope.indices = Index.query({ action: 'single-date', previousPrice: true });
    };

    $scope.labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    $scope.series = ['Series A', 'Series B'];
    $scope.data = [
      [65, 59, 80, 81, 56, 55, 40],
      [28, 48, 40, 19, 86, 27, 90]
    ];
  }
]);
