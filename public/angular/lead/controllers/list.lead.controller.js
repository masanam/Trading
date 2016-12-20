'use strict';

angular.module('lead').controller('ListLeadController', ['$scope', '$location', 'Order', 'Lead',
  function($scope, $location, Order, Lead) {

    $scope.init = function(){
      $scope.lead_type=$location.search().lead_type;
    };

    $scope.getUsed = function(lead){
      $scope.used = 0;
      for(var i = 0; i < lead.used.length; i++){
        $scope.used += lead.used[i].volume;
      }
      return $scope.used;
    };
    
    $scope.findStatus = function($order_status, $lead_type) {
      $scope.leads = Lead.query({ lead_type: $lead_type, order_status: $order_status });
    };

    $scope.status = function (lead, status) {
      lead.order_status = status;

      lead.$update(function(res){
        $scope.leads.splice($scope.leads.indexOf(lead), 1);
      });
    };

  }
]);