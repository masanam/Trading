'use strict';

angular.module('lead').controller('OperationLeadController', ['$scope', '$stateParams', '$location', '$uibModal', 'Concession', 'Factory', 'Lead', 'NgMap',
  function($scope, $stateParams, $location, $uibModal, Concession, Factory, Lead, NgMap) {

    $scope.init = function(){
      $scope.concession = {};
      $scope.factory = {};
      $scope.id = $stateParams.id;
      $scope.lead = Lead.get({ id: $stateParams.id }, function(res){
        if (res.lead_type==='b'){
          $scope.lead_type = 'buy';
          $scope.operation_type = 'Concession';
        }
        else if (res.lead_type==='s') {
          $scope.lead_type = 'sell';
          $scope.operation_type = 'Factory';
        }
      });

      //init map
      var map;
      $scope.$on('mapInitialized', function(evt, evtMap) {
        map = evtMap;
        $scope.markerMove = function(e) {
          $scope.factory.latitude = e.latLng.lat();
          $scope.factory.longitude = e.latLng.lng();
        };
      });
    };

    //Init select concession
    $scope.findMyConcessions = function() {
      $scope.concessions = Concession.query({ supplier_id: $scope.lead.company_id }, function(concessions){
        if(concessions.length === 0){
          $scope.openModal();
        }else{
          for (var i = 0; i < concessions.length ; i++) {
            $scope.concessions[i].license_expiry_date = new Date(concessions[i].license_expiry_date);
          }
        }
      });
    };

    //Init select factory
    $scope.findMyFactorys = function() {
      $scope.factorys = Factory.query({ company_id: $scope.lead.company_id }, function(factorys){
        if(factorys.length === 0){
          $scope.openModal();
        }
      });
    };

    //button next to product page
    $scope.nextToProduct = function(){
      $scope.lead = new Lead({
        company_id: $scope.lead.company_id,
        concession_id: $scope.concession.selected.id,
        address: $scope.concession.selected.address,
        city: $scope.concession.selected.city,
        country: $scope.concession.selected.country,
        latitude: $scope.concession.selected.latitude,
        longitude: $scope.concession.selected.longitude,
        order_status: 2
      });
      $scope.lead.$update({ type: $scope.lead_type, id: $stateParams.id }, function(res) {
        $scope.lead.factory_id = $scope.concession.selected.id;
        $location.path('lead/'+res.id+'/product');
      });
    };
    
    //open modal create concession
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/sell-order/modal.concession.view.html',
        controller: 'ConcessionModalSellOrderController',
        scope: $scope
      });
    };

  }
]);