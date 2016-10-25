'use strict';

angular.module('port').controller('PortController', ['$scope', '$stateParams', '$uibModal', '$location', 'Port',
  function($scope, $stateParams, $uibModal, $location, Port) {

    $scope.init = function(){
      $scope.buyer_ports = [];
      $scope.buyer_port = new Port();
      $scope.ports=[];
      $scope.port={};
      $scope.new = $location.search().new;
    };

    $scope.findAllPorts = function(){
      $scope.ports = Port.query();
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

    $scope.openModalNewSeller = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/lead/views/port/seller/seller-create.view.html',
        controller: 'PortModalController',
        scope: $scope
      });
    };

    $scope.nextToFinish= function(){
      $location.path('lead/buyer/'+$stateParams.id);
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

    $scope.backToProduct= function(){
      $location.path('lead/buyer/'+$stateParams.id+'/setup-product');
    };

    $scope.backToProductSeller= function(){
      $location.path('lead/seller/'+$stateParams.id+'/setup-product');
    };

  }
]);



angular.module('port').controller('PortModalController', function ($scope, $stateParams, $uibModalInstance, $interval, Port, $location) {

  $scope.init = function(type){
    $scope.port = new Port();
    $scope.buyer_port = new Port();
    $scope.seller_port = new Port();
    $scope.port.has_blending = 0;
    $scope.port.has_conveyor = 0;
    $scope.port.has_crusher = 0;
    $scope.type = type;
  };

  $scope.findAllPorts = function(){
    $scope.ports = Port.query();
  };

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
            $location.path('lead/buyer/'+$stateParams.id);
          } else {
            $interval.cancel(stop);
            stop = undefined;
            $scope.ports.push(res);
            $scope.ports[$scope.ports.length-1].port = $scope.port;
            $uibModalInstance.close('success');
          }
        }, 75);
      });
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
            stop = undefined;
            $uibModalInstance.close('success');
          }
        }, 75);
      });
    });
  };

  $scope.close = function () {
    $uibModalInstance.dismiss('cancel');
  };
});