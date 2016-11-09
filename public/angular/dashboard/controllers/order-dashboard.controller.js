'use strict';

angular.module('dashboard').controller('OrderDashboardController', ['$scope', 'Index','Order','Authentication',
  function($scope, Index, Order, Authentication) {
    $scope.Authentication = Authentication;

    //find list of order in dashboard
    $scope.find = function () {
    	if( Authentication.user.role === 'manager'){
    		$scope.orders = Order.query({ possession: 'subordinates', status: 'p' });
    	}

    	if( Authentication.user.role === 'trader'){
			$scope.orders = Order.query({ possession: 'my', status: 'p' });
    	}
      
    };
  }
]);
