'use strict';

angular.module('lead').controller('LeadController', ['$scope', '$state', '$stateParams', '$filter', 'Environment', 'Authentication', 'Order', 'Lead', 'Term', 'Country',
  function($scope, $state, $stateParams, $filter, Environment, Authentication, Order, Lead, Term, Country) {

    $scope.Authentication = Authentication;
    $scope.tradingTerm = Term.trading;
    $scope.paymentTerm = Term.payment;
    $scope.carrierTypes = Term.carrierTypes;
    $scope.showBuy = Environment.showBuy;
    $scope.deployment = Environment.deployment;
    $scope.destinationBy = Environment.destinationBy;
    $scope.productQuality = Environment.productQuality;

    $scope.today = new Date();

    $scope.countries = Country.query();
    $scope.selected = {};

    if(!$stateParams.lead_type) $scope.lead = Lead.get({ id:$stateParams.id });

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

    $scope.find = function(status, $search) {
      if(!status) status = $stateParams.status;
      console.log($stateParams.lead_type);
      var lead_type = $stateParams.lead_type;
      console.log(lead_type);
      $scope.leads = Lead.query({ order_status: $scope.status, lead_type: $stateParams.lead_type, q:$search });
    };

    $scope.findStatus = function($order_status, $lead_type) {
      $scope.status = $order_status;
      $scope.leads = Lead.query({ lead_type: $lead_type, order_status: $order_status });
    };

    $scope.findRecommendations = function () {
      $scope.leadRecommendations = Lead.query({ matching: 'leads', lead_id: $stateParams.id, lead_type:$scope.lead.lead_type });
      $scope.productRecommendations = Lead.query({ matching: 'products', lead_id: $stateParams.id });
    };

    $scope.init = function () {
      $scope.lead = new Lead();
      $scope.lead_type=$stateParams.lead_type;
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
      console.log(lead);
      lead.company_id = $scope.selected.company.id;

      lead.$save(function(res) {
        $state.go('lead.location', { id: res.id });
      });
    };

    $scope.status = function (lead, status) {
      var action;

      switch(status){
        case 'x' : action = 'delete'; break;
        case 'v' : action = 'verify'; break;
        default : action = 'modify'; break;
      }

      var change = confirm('Do you want to ' + action + ' this record?');

      if(change){
        lead.order_status = status;

        lead.$update(function(res){
          if(res.lead_type==='b') $scope.lead_type = 'buy';
          else $scope.lead_type = 'sell';
          if (status === 'x') {
            $state.go('lead.list', { lead_type: $scope.lead_type });
          }
          else lead = res;
        });
      }
    };

    $scope.update = function () {
      var next;

      console.log($scope.lead);

      if($state.current.name === 'lead.update') next = 'lead.location';
      else if($state.current.name === 'lead.location'){
        // if location is by country, skip port
        if(Environment.destinationBy === 'country'){
          $scope.lead.order_status+=2;
          next = 'lead.product';
        } else {
          $scope.lead.order_status++;
          next = 'lead.port';
        }
      }
      else if($state.current.name === 'lead.port') next = 'lead.product';
      else if($state.current.name === 'lead.product') {
        next = 'lead.view';
        if (
          (!(($scope.lead.gcv_adb_bonus && $scope.lead.gcv_adb_reject) ||
          ($scope.lead.gcv_arb_bonus && $scope.lead.gcv_arb_reject) ||
          ($scope.lead.ncv_bonus && $scope.lead.ncv_reject))) &&
          Environment.productQuality !== 'typical'
          ) {
          $scope.error = 'Please Fill Contract Bonus & Reject';
          return false;
        }else if(Environment.productQuality === 'typical'){
          $scope.lead.gcv_adb_max = $scope.lead.gcv_adb_min;
          $scope.lead.gcv_arb_max = $scope.lead.gcv_arb_min;
          $scope.lead.ncv_max = $scope.lead.ncv_min;
          $scope.lead.tm_max = $scope.lead.tm_min;
          $scope.lead.im_max = $scope.lead.im_min;
          $scope.lead.vm_max = $scope.lead.vm_min;
          $scope.lead.ash_max = $scope.lead.ash_min;
          $scope.lead.fc_max = $scope.lead.fc_min;
          $scope.lead.ts_max = $scope.lead.ts_min;
          $scope.lead.hgi_max = $scope.lead.hgi_min;
          $scope.lead.size_max = $scope.lead.size_min;
          $scope.lead.fe2o3_max = $scope.lead.fe2o3_min;
          $scope.lead.aft_max = $scope.lead.aft_min;
          $scope.lead.na2o_max = $scope.lead.na2o_min;
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
