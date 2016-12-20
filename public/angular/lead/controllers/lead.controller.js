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

        if($scope.lead.user_id === Authentication.user.id && $state.current.name !== 'lead.view'){
          if($scope.lead.company_id) $scope.selected.company = $scope.lead.company;
          if($scope.lead.port_id) $scope.selected.port = $scope.lead.port;
          if($scope.lead.product_id) $scope.selected.product = $scope.lead.product;

          if ($scope.lead.lead_type === 'b') $scope.selected.location = $scope.lead.concession;
          else $scope.selected.location = $scope.lead.factory;

          $scope.$watch('selected.port', function (newValue, oldValue) {
            if($scope.lead){
              if(newValue){
                $scope.lead.port_id = newValue.id;
                $scope.lead.port_name = newValue.port_name;
                $scope.lead.port_status = newValue.status;
                $scope.lead.port_daily_rate = newValue.daily_rate;
                $scope.lead.port_draft_height = newValue.draft_height;
                $scope.lead.port_latitude = newValue.latitude;
                $scope.lead.port_longitude = newValue.longitude;
              }
              else $scope.lead.port_id = undefined;
            }
          });

          $scope.$watch('selected.product', function (newValue, oldValue) {
            if($scope.lead){
              if(newValue){
                $scope.lead.product_id = newValue.id;
                $scope.lead.product_name = newValue.product_name;
                $scope.lead.typical_quality = newValue.typical_quality;

                $scope.lead.gcv_adb_min = newValue.gcv_adb_min;
                $scope.lead.gcv_adb_max = newValue.gcv_adb_max;
                $scope.lead.gcv_arb_min = newValue.gcv_arb_min;
                $scope.lead.gcv_arb_max = newValue.gcv_arb_max;
                $scope.lead.ncv_min = newValue.ncv_min;
                $scope.lead.ncv_max = newValue.ncv_max;
                $scope.lead.tm_min = newValue.tm_min;
                $scope.lead.tm_max = newValue.tm_max;
                $scope.lead.im_min = newValue.im_min;
                $scope.lead.im_max = newValue.im_max;
                $scope.lead.vm_min = newValue.vm_min;
                $scope.lead.vm_max = newValue.vm_max;
                $scope.lead.ash_min = newValue.ash_min;
                $scope.lead.ash_max = newValue.ash_max;
                $scope.lead.fc_min = newValue.fc_min;
                $scope.lead.fc_max = newValue.fc_max;
                $scope.lead.ts_min = newValue.ts_min;
                $scope.lead.ts_max = newValue.ts_max;
                $scope.lead.hgi_min = newValue.hgi_min;
                $scope.lead.hgi_max = newValue.hgi_max;
                $scope.lead.size_min = newValue.size_min;
                $scope.lead.size_max = newValue.size_max;
                $scope.lead.fe2o3_min = newValue.fe2o3_min;
                $scope.lead.fe2o3_max = newValue.fe2o3_max;
                $scope.lead.aft_min = newValue.aft_min;
                $scope.lead.aft_max = newValue.aft_max;
              }
              else $scope.lead.product_id = undefined;
            }
          });

          $scope.$watch('selected.location', function (newValue, oldValue) {
            if($scope.lead){
              if(newValue){
                if ($scope.lead.lead_type === 'b') $scope.lead.concession_id = newValue.id;
                else $scope.lead.factory_id = newValue.id;

                $scope.lead.address = newValue.address;
                $scope.lead.city = newValue.city;
                $scope.lead.country = newValue.country;
                $scope.lead.port_distance = newValue.port_distance;
                $scope.lead.latitude = newValue.latitude;
                $scope.lead.longitude = newValue.longitude;
              }
              else $scope.lead.port_id = undefined;
            }
          });

          $scope.$watch('selected.company', function (newValue, oldValue) {
            if(newValue){
              $scope.lead.company_id = newValue.id;
              if(!$scope.lead.trading_term) $scope.lead.trading_term = newValue.preferred_trading_term;
              if(!$scope.lead.payment_term) $scope.lead.payment_term = newValue.preferred_payment_term;
            } else {
              if(!isNaN($scope.lead.order_status)) $scope.lead.company_id = undefined;
              else {
                $scope.selected.company = oldValue;
                alert('You can only edit company in draft leads');
              }
            }
          });
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
      else if($state.current.name === 'lead.location') next = 'lead.product';
      else if($state.current.name === 'lead.product') {
        next = 'lead.view';
        if (!(
          ($scope.lead.gcv_adb_bonus&&$scope.lead.gcv_adb_reject)||
          ($scope.lead.gcv_arb_bonus&&$scope.lead.gcv_arb_reject)||
          ($scope.lead.ncv_bonus&&$scope.lead.ncv_reject)
          )) {
          $scope.error = 'Please Fill Contract Bonus & Reject';
          return;
        }
        else $scope.error = null;
      }
      else next = 'lead.view';

      console.log($scope.lead.order_status);
      //number logics
      switch($scope.lead.order_status){
        case 1 : $scope.lead.order_status++;
          break;
        case 2 : $scope.lead.order_status = 'l';
          break;
      }
      console.log($scope.lead.order_status);

      $scope.lead.$update(function(res){
        $state.go(next, { id: res.id });
      });
    };
  }
]);