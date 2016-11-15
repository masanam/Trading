'use strict';

angular.module('operation').controller('OperationController', ['$scope', '$stateParams', 'Order', 'OrderUser', 'Authentication', '$location', 'Chat',
	function($scope, $stateParams, Order, OrderUser, Authentication, $location, Chat) {

  $scope.buying = {
    value1 : false
  };

  $scope.selling = {
    value2 : false
  };

  $scope.supplier = {
    value3 : false
  };

  $scope.costumer = {
    value4 : false
  };

}]);