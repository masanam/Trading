'use strict';

angular.module('dashboard').controller('MainDashboardController', ['$scope', 'Index','Order','Authentication',
  function($scope, Index, Order, Authentication) {
    $scope.getIndices = function () {
      $scope.date = new Date();
      $scope.indexPage = 0;
      $scope.indices = Index.query({ action: 'single-date' });
    };

    //find list of order in dashboard
    $scope.findDashboard = function () {
      if(Authentication.user.role === 'trader'){
        $scope.orders = Order.query({ possession: 'my', status: 'p' });
      }
    };

  }
]);
