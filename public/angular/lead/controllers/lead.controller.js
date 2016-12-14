'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$stateParams', 'Authentication', 'Order', 'Lead', 'Term',
  function($scope, $stateParams, Authentication, Order, Lead, Term) {
  	$scope.Authentication = Authentication;
  	$scope.tradingTerm = Term.trading;
  	$scope.paymentTerm = Term.payment;

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

    $scope.init = function () {
    	$scope.lead = new Lead();
    };

  }
]);