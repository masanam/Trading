'use strict';
angular.module('lead').controller('LeadController', ['$scope', '$state', '$stateParams', 'Environment', 'Authentication', 'Order', 'Lead', 'Term',
  function($scope, $state, $stateParams, Environment, Authentication, Order, Lead, Term) {
    $scope.Authentication = Authentication;
    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;
    $scope.showBuy = Environment.showBuy;
    $scope.selected = {};

    $scope.findOne = function(id){
      if(!id) id = $stateParams.id;
      Lead.get({ id: id }, function(res){
        $scope.lead = res;  

        if($scope.lead.user_id === Authentication.user.id && $state.current.name !== 'lead.view'){
          if($scope.lead.company_id) $scope.selected.company = $scope.lead.company;
          if($scope.lead.port_id) $scope.selected.port = $scope.lead.port;
          if($scope.lead.product_id) $scope.selected.product = $scope.lead.product;

          if ($scope.lead.lead_type === 'b') $scope.selected.location = $scope.lead.concession;
          else $scope.selected.location = $scope.lead.factory;
        }
      });
    };

    $scope.find = function(status, lead_type) {
      if(!status) status = $stateParams.status;
      if(!lead_type) lead_type = $stateParams.lead_type;
      $scope.leads = Lead.query({ status: status, type: lead_type });
    };

    $scope.findRecommendations = function () {
      $scope.leadRecommendations = Lead.query({ matching: 'leads', lead_id: $stateParams.id, lead_type:$scope.lead.lead_type });
      $scope.productRecommendations = Lead.query({ matching: 'products', lead_id: $stateParams.id });
    };

    $scope.init = function () {
      $scope.lead = new Lead();
      if($stateParams.lead_type) $scope.lead.lead_type = $stateParams.lead_type;
      if(Environment.trx === 'sell') $scope.lead.lead_type = 'sell';
    };
    
    $scope.getUsed = function(lead){
      $scope.used = 0;
      if (lead.used) {
        for(var i = 0; i < lead.used.length; i++){
          $scope.used += lead.used[i].volume;
        }
      }
      return $scope.used;
    };

    $scope.create = function (lead) {
      lead = new Lead(lead);
      lead.company_id = $scope.selected.company.id;

      lead.$save(function(res) {
        $state.go('lead.location', { id: res.id });
      });
    };

    $scope.status = function (lead, status) {
      lead.order_status = status;

      lead.$update(function(res){
        if(res.lead_type==='b') $scope.lead_type = 'buy';
        else $scope.lead_type = 'sell';
        if (status === 'x') {
          $state.go('lead.list', { lead_type: $scope.lead_type });
        }
        else lead = res;
      });
    };

    $scope.update = function () {
      var next;

      if($state.current.name === 'lead.update') next = 'lead.location';
      else if($state.current.name === 'lead.location') next = 'lead.port';
      else if($state.current.name === 'lead.port') next = 'lead.product';
      else if($state.current.name === 'lead.product') {
        next = 'lead.view';
        if (
          !(($scope.lead.gcv_adb_bonus && $scope.lead.gcv_adb_reject) ||
          ($scope.lead.gcv_arb_bonus && $scope.lead.gcv_arb_reject) ||
          ($scope.lead.ncv_bonus && $scope.lead.ncv_reject))
          ) {
          $scope.error = 'Please Fill Contract Bonus & Reject';
          return false;
        }
        else $scope.error = null;
      }
      else next = 'lead.view';

      //number logics
      switch($scope.lead.order_status){
        case 1 : 
        case 2 : 
          $scope.lead.order_status++;
          break;
        case 3 : $scope.lead.order_status = 'l';
          break;
      }

      $scope.lead.$update(function(res){
        $state.go(next, { id: res.id });
      });
    };
  }
]);