'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$state', '$stateParams', 'Authentication', 'Order', 'Lead', 'Term',
  function($scope, $state, $stateParams, Authentication, Order, Lead, Term) {
    $scope.Authentication = Authentication;
    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;
    $scope.selected = {};

    $scope.findOne = function(id){
      if(!id) id = $stateParams.id;
      Lead.get({ id: id }, function(res){
        $scope.lead = res;  
        if($scope.lead.company_id) $scope.selected.company = $scope.lead.company;
        if($scope.lead.port_id) $scope.selected.port = $scope.lead.port;
        if($scope.lead.product_id) $scope.selected.product = $scope.lead.product;

        if ($scope.lead.lead_type === 'b') $scope.selected.location = $scope.lead.concession;
        else $scope.selected.location = $scope.lead.factory;
      });
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
      var next;

      if($state.current.name === 'lead.update') next = 'lead.location';
      else if($state.current.name === 'lead.location') next = 'lead.product';
      else if($state.current.name === 'lead.product') next = 'lead.view';
      else next = 'lead.view';

      console.log($scope.lead.order_status);
      //number logics
      switch($scope.lead.order_status){
        case 1 :
        case 2 : $scope.lead.order_status++;
          break;
      }
      console.log($scope.lead.order_status);

      $scope.lead.$update(function(res){
        $state.go(next, { id: res.id });
      });
    };
  }
]);