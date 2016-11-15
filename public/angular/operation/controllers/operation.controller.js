'use strict';

angular.module('operation').controller('OperationController', ['$scope', '$stateParams', 'Order', 'OrderUser', 'Authentication', '$location', 'Chat',
	function($scope, $stateParams, Order, OrderUser, Authentication, $location, Chat) {

  $scope.buying = {
    value : false
  };

  $scope.selling = {
    value : false
  };

  $scope.supplier = {
    value : false
  };

  $scope.costumer = {
    value : false
  };

}]);