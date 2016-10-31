'use strict';

angular.module('order').controller('SellOrderPortController', ['$scope', '$stateParams', '$location', '$uibModal', 'Port', 'Concession', 'Order',
  function($scope, $stateParams, $location, $uibModal, Port, Concession, Order) {

    $scope.port = {};
    $scope.order_id = $stateParams.order_id;
    $scope.concession_id = $stateParams.concession_id;


    //Init select port
    $scope.findAllPorts = function(){
      $scope.ports = Port.query();
    };

    //selected port after create new
    $scope.postCreatePorts = function(){
      $scope.ports = Port.query({}, {}, function(){
        $scope.port.selected = $scope.ports[$scope.ports.length-1];
      });
    };

    //back button to product
    $scope.backToProduct = function(){
      $location.path('sell-order/create/product/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.concession_id);
    };

    //button next to summary page and update order update concession port
    $scope.nextSummary = function(){
      if($scope.port.distance) {
        Concession.get({ id: $scope.concession_id }, function(res){
          $scope.concession = res;
          $scope.concession.port_id = $scope.port.selected.id;
          $scope.concession.port_distance = $scope.port.distance;
          $scope.concession.$update({ id: $scope.concession_id });
        });
        Order.get({ type: 'sell', id: $stateParams.order_id }, function(res){
          $scope.order = res;
          $scope.order.seller_id = $stateParams.id;
          $scope.order.port_distance = $scope.port.distance;
          $scope.order.port_id = $scope.port.selected.id;
          $scope.order.port_name = $scope.port.selected.port_name;
          $scope.order.port_status = $scope.port.selected.is_private;
          $scope.order.port_daily_rate = $scope.port.selected.daily_discharge_rate;
          $scope.order.port_draft_height = $scope.port.selected.draft_height;
          $scope.order.port_latitude = $scope.port.selected.latitude;
          $scope.order.port_longitude = $scope.port.selected.longitude;
          
          $scope.order.order_status = 4;
          
          $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
            $location.path('sell-order/create/summary/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.concession_id);
          });
        });
      }
      else{
        $scope.error = 'Please fill Distance from Discharging Port to Concession !';
      }
      
    };
    
    //open modal create port
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/sell-order/modal.port.view.html',
        controller: 'PortModalSellOrderController',
        scope: $scope
      });
    };

  }
]);