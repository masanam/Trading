'use strict';

angular.module('dashboard').controller('MainDashboardController', ['$scope', 'Index',
  function($scope, Index) {
    $scope.getIndices = function () {
      $scope.date = new Date();
      $scope.indexPage = 0;
      $scope.indices = Index.query({ action: 'single-date' });
    };
  }
]);
