'use strict';
angular.module('lead').controller('LeadController', ['$scope', '$state', '$stateParams', 'Authentication', 'Order', 'Lead', 'Term',
  function($scope, $state, $stateParams, Authentication, Order, Lead, Term) {
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
      if($stateParams.lead_type) $scope.lead.lead_type = $stateParams.lead_type;
    };

    $scope.create = function (lead) {
      lead = new Lead(lead);

      lead.$save(function(res) {
        $state.go('lead.location', { id: res.id });
      });
    };

    $scope.update = function () {
      $scope.lead.$update(function(res){
        var next;

        if($state.current.name === 'lead.update') next = 'lead.location';
        if($state.current.name === 'lead.location') next = 'lead.product';
        else if($state.current.name === 'lead.product') next = 'lead.view';
        else next = 'lead.view';

        $state.go(next, { id: res.id });
      });
    };
  }
]);