'use strict';

angular.module('dashboard').controller('OrderDashboardController', ['$scope', 'Index','Order','Authentication',
  function($scope, Index, Order, Authentication) {
    $scope.Authentication = Authentication;

    //find list of order in dashboard
    $scope.find = function () {
      var possession;

      if( Authentication.user.role === 'manager') possession = 'subordinates';
      else if( Authentication.user.role === 'trader') possession = 'my';

      $scope.orders = Order.query({ possession: possession, status: 'p' });
    };
  }
]);
