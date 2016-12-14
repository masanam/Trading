'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$stateParams', 'Authentication', 'Order', 'Lead',
  function($scope, $stateParams, Authentication, Order, Lead) {
  	$scope.Authentication = Authentication;

    $scope.findOne = function(id){
      if(!id) id = $stateParams.id;
      $scope.lead = Lead.get({ id: id });
    };

    $scope.find = function(status) {
    	if(!status) status = $stateParams.status;
      $scope.leads = Lead.query({ status: status });
    };

    $scope.findRecommendations = function () {
    	$scope.leadRecommendations = Lead.query({ matching: 'leads', lead_id: $stateParams.id });
    	$scope.productRecommendations = Lead.query({ matching: 'products', lead_id: $stateParams.id });
    };

  }
]);