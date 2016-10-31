'use strict';

angular.module('order').controller('BuyOrderPortController', ['$scope', '$stateParams', '$location', '$uibModal', 'Port', 'Factory', 'Order',
  function($scope, $stateParams, $location, $uibModal, Port, Factory, Order) {

    $scope.port = {};
    $scope.order_id = $stateParams.order_id;
    $scope.factory_id = $stateParams.factory_id;


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
      $location.path('buy-order/create/product/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
    };

    //button next to summary page and update order update factory port
    $scope.nextSummary = function(){
      if($scope.port.distance) {
        Factory.get({ id: $scope.factory_id }, function(res){
          $scope.factory = res;
          $scope.factory.port_id = $scope.port.selected.id;
          $scope.factory.port_distance = $scope.port.distance;
          $scope.factory.$update({ id: $scope.factory_id });
        });
        Order.get({ type: 'buy', id: $stateParams.order_id }, function(res){
          $scope.order = res;
          $scope.order.buyer_id = $stateParams.id;
          $scope.order.port_distance = $scope.port.distance;
          $scope.order.port_id = $scope.port.selected.id;
          $scope.order.port_name = $scope.port.selected.port_name;
          $scope.order.port_status = $scope.port.selected.is_private;
          $scope.order.port_daily_rate = $scope.port.selected.daily_discharge_rate;
          $scope.order.port_draft_height = $scope.port.selected.draft_height;
          $scope.order.port_latitude = $scope.port.selected.latitude;
          $scope.order.port_longitude = $scope.port.selected.longitude;
          
          $scope.order.order_status = 4;
          
          $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
            $location.path('buy-order/create/summary/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
          });
        });
      }
      else{
        $scope.error = 'Please fill Distance from Discharging Port to Factory !';
      }
      
    };
    
    //open modal create port
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/buy-order/modal.port.view.html',
        controller: 'PortModalBuyOrderController',
        scope: $scope
      });
    };

  }
]);