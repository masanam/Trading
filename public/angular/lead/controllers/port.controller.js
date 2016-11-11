'use strict';

angular.module('port').controller('PortController', ['$scope', '$stateParams', '$uibModal', '$location', 'Port', 'MultiStepForm', 'Factory', 'Concession', '$window','$state',
  function($scope, $stateParams, $uibModal, $location, Port, MultiStepForm, Factory, Concession, $window, $state) {

    $scope.init = function(){
      $scope.buyer_ports = [];
      $scope.tempFactoryId = MultiStepForm.tempFactoryId;
      $scope.tempConcessionId = MultiStepForm.tempConcessionId;
      $scope.buyer_port = new Port();
      $scope.ports=[];
      $scope.port={};
      $scope.concession={};
      $scope.factory={};
      $scope.selectedPort = {};
      $scope.new = $location.search().new;
    };


    $scope.findOne = function(){
      Port.get({ id: $stateParams.portId }, function(res){
        $scope.port = res;
        $scope.port.longitude = parseFloat($scope.port.longitude);
        $scope.port.latitude = parseFloat($scope.port.latitude);
      });
    };

    $scope.backToDetail = function(){
      $window.history.back();
    };

    $scope.backToDetailBuyer = function(){
      $location.path('lead/buyer/'+$stateParams.id);
    };

    $scope.backToDetailSeller = function(){
      $location.path('lead/seller/'+$stateParams.id);
    };

    $scope.findAllPorts = function(){
      $scope.ports = Port.query({}, {}, function(){
        $scope.port.selected = $scope.ports[$scope.ports.length-1];
      });
    };

    $scope.findMyPortsBuyer = function(){
      $scope.ports = Port.query({ type: 'buyer', action: 'my', id: $stateParams.id });
    };

    $scope.findMyPortsSeller = function(){
      $scope.ports = Port.query({ type: 'seller', action: 'my', id: $stateParams.id });
    };

    $scope.openModalNewBuyer = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/buyer/buyer-create.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.openModalDetailBuyer = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/buyer/detail.buyer-create.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.openModalNewSeller = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/seller/seller-create.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.openModalDetailSeller = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/seller/detail.seller-create.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.update = function() {
      $scope.loading = true;

      $scope.port.$update({ id: $stateParams.portId }, function(res) {
        $location.path('lead/port/'+$stateParams.portId);
        $scope.loading = false;
      });
    };



    $scope.finishBuyer= function(){
      if ($scope.port.selected) {
        
        $scope.factory = Factory.get({ id: MultiStepForm.tempFactoryId }, function(res){
          
          $scope.factory = res;
          $scope.factory.port_id = $scope.port.selected.id;
          
          $scope.factory.$update({ id: $scope.factory.id }, function (res){
            MultiStepForm.tempFactoryId = undefined;
          });
        });
        
        $location.path('lead/buyer/'+$stateParams.id);
      }else{
        $scope.error = 'Please Select A Port or Create New port';
      }
    };

    $scope.finishSeller= function(){
      if ($scope.port.selected) {
      
        Concession.get({ id: MultiStepForm.tempConcessionId }, function(res){
          $scope.concession = res;
          $scope.concession.port_id = $scope.port.selected.id;
          
          $scope.concession.$update({ id: $scope.concession.id }, function (res){
            MultiStepForm.tempConcessionId = undefined;
          });
        });
        
        $location.path('lead/seller/'+$stateParams.id);
      }else{
        $scope.error = 'Please Select A Port or Create New port';
      }
    };

    $scope.openModalAvailableBuyer = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/available/buyer-available.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.openModalAvailableSeller = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/available/seller-available.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.backToProduct = function(){
      $location.path('lead/buyer/'+$stateParams.id+'/setup-product');
    };

    $scope.backToProductSeller = function(){
      $location.path('lead/seller/'+$stateParams.id+'/setup-product');
    };

    //Delete a Buyer port at Detail Buyer
    $scope.delete = function(port, type){
      $scope.ports.splice($scope.ports.indexOf(port), 1);
      Port.query({ type:type, action: 'detachPort', id: $stateParams.id, portId:port.id });
    };

  }
]);



angular.module('port').controller('PortModalController', function ($scope, $stateParams, $uibModalInstance, $interval, Port, $location, MultiStepForm, Factory, Concession) {

  $scope.init = function(type){
    $scope.port = new Port();
    $scope.buyer_port = new Port();
    $scope.seller_port = new Port();
    $scope.port.has_blending = 0;
    $scope.port.has_conveyor = 0;
    $scope.port.has_crusher = 0;
    $scope.type = type;
  };

  /*$scope.findAllPorts = function(){
    $scope.ports = Port.query();
    $scope.port.selected = $scope.ports[0] ;
  };*/

  $scope.saveAvailableBuyer = function(){
    $scope.buyer_port.buyer_id = $stateParams.id;
    $scope.buyer_port.$save({ type: 'buyer', action: 'store' }, function(res) {
      $scope.ports.push(res);
      $uibModalInstance.close('success');
    });
  };

  $scope.saveAvailableSeller = function(){
    $scope.seller_port.buyer_id = $stateParams.id;
    $scope.seller_port.$save({ type: 'seller', action: 'store' }, function(res) {
      $scope.ports.push(res);
      $uibModalInstance.close('success');
    });
  };

  $scope.savePortBuyer = function(){
    // console.log($scope.ports);
    var port = new Port({
      port_name: $scope.port.port_name,
      anchorage_distance: $scope.port.anchorage_distance,
      daily_discharge_rate: $scope.port.daily_discharge_rate,
      draft_height: $scope.port.draft_height,
      has_blending: $scope.port.has_blending,
      has_conveyor: $scope.port.has_conveyor,
      has_crusher: $scope.port.has_crusher,
      is_private: $scope.port.is_private,
      latitude: $scope.port.latitude,
      location: $scope.port.location,
      longitude: $scope.port.longitude,
      owner: $scope.port.owner,
      size: $scope.port.size
    });
    port.$save(function(res) {
      $scope.port = res;
      $scope.buyer_port.buyer_id = $stateParams.id;
      
      $scope.buyer_port.port_id = res.id;
      $scope.buyer_port.$save({ type: 'buyer', action: 'store' }, function(res) {
        $scope.progress = 0;
        $scope.success = true;
        var stop = $interval(function() {
          if ($scope.progress >= 0 && $scope.progress < 100) {
            $scope.progress++;
            $scope.selected = $scope.port.port_name ;
          } else {
            $interval.cancel(stop);
            //stop = undefined;
            //$scope.ports.push(res);
            //$scope.ports[$scope.ports.length-1].port = $scope.port;
            $scope.selectedPort = res;
            $scope.findAllPorts();
            $uibModalInstance.close('success');
          }
        }, 75);
      });
    });
  };

  $scope.savePortDetailBuyer = function(){
    var port = new Port({
      port_name: $scope.port.port_name,
      anchorage_distance: $scope.port.anchorage_distance,
      daily_discharge_rate: $scope.port.daily_discharge_rate,
      draft_height: $scope.port.draft_height,
      has_blending: $scope.port.has_blending,
      has_conveyor: $scope.port.has_conveyor,
      has_crusher: $scope.port.has_crusher,
      is_private: $scope.port.is_private,
      latitude: $scope.port.latitude,
      location: $scope.port.location,
      longitude: $scope.port.longitude,
      owner: $scope.port.owner,
      size: $scope.port.size
    });
    port.$save(function(res) {
      Port.query({ type:'buyer', action: 'attachPort', id: $stateParams.id, portId:res.id });
      $scope.success = true;
      $scope.findMyPortsBuyer();
      $uibModalInstance.close('success');
    });
  };

  $scope.savePortSeller = function(){
    var port = new Port({
      port_name: $scope.port.port_name,
      anchorage_distance: $scope.port.anchorage_distance,
      daily_discharge_rate: $scope.port.daily_discharge_rate,
      draft_height: $scope.port.draft_height,
      has_blending: $scope.port.has_blending,
      has_conveyor: $scope.port.has_conveyor,
      has_crusher: $scope.port.has_crusher,
      is_private: $scope.port.is_private,
      latitude: $scope.port.latitude,
      location: $scope.port.location,
      longitude: $scope.port.longitude,
      owner: $scope.port.owner,
      size: $scope.port.size
    });
    port.$save(function(res) {
      $scope.ports.push(res);
      $scope.seller_port.seller_id = $stateParams.id;
      $scope.seller_port.port_id = res.id;
      
      $scope.seller_port.$save({ type: 'seller', action: 'store' }, function(res) {
        $scope.progress = 0;
        $scope.success = true;
        
        var stop = $interval(function() {
          if ($scope.progress >= 0 && $scope.progress < 100) {
            $scope.progress++;
          } else {
            $interval.cancel(stop);
            //stop = undefined;
            $scope.selectedPort = res;
            $scope.findAllPorts();
            $uibModalInstance.close('success');
          }
        }, 75);
      });
    });
  };

  $scope.savePortDetailSeller = function(){
    var port = new Port({
      port_name: $scope.port.port_name,
      anchorage_distance: $scope.port.anchorage_distance,
      daily_discharge_rate: $scope.port.daily_discharge_rate,
      draft_height: $scope.port.draft_height,
      has_blending: $scope.port.has_blending,
      has_conveyor: $scope.port.has_conveyor,
      has_crusher: $scope.port.has_crusher,
      is_private: $scope.port.is_private,
      latitude: $scope.port.latitude,
      location: $scope.port.location,
      longitude: $scope.port.longitude,
      owner: $scope.port.owner,
      size: $scope.port.size
    });
    port.$save(function(res) {
      Port.query({ type:'seller', action: 'attachPort', id: $stateParams.id, portId:res.id });
      $scope.success = true;
      $scope.findMyPortsSeller();
      $uibModalInstance.close('success');
    });
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});