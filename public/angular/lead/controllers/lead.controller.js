'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$stateParams', 'Order', 'Lead',
  function($scope, $stateParams, Order, Lead) {

    $scope.findOne = function(id){
      if(!id) id = $stateParams.id;
      $scope.lead = Lead.get({ id: id });
    };

    $scope.find = function(status) {
    	if(!status) status = $stateParams.status;
      $scope.leads = Lead.query({ status: status });
    };

  }
]);