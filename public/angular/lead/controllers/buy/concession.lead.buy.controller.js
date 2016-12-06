'use strict';

angular.module('lead').controller('ConcessionLeadBuyController', ['$scope', '$stateParams', '$location', '$filter', '$uibModal', 'Concession', 'Lead', 'Order',
  function($scope, $stateParams, $location, $filter, $uibModal, Concession, Lead, Order) {

    $scope.concession = {};
    $scope.id = $stateParams.id;

    //Init select concession
    $scope.findConcessions = function() {
      $scope.concessions = Concession.query({ supplier_id: $stateParams.supplier_id }, function(concessions){
        if(concessions.length === 0){
          $scope.openModal();
        }else{
          for (var i = 0; i < concessions.length ; i++) {
            $scope.concessions[i].license_expiry_date = new Date(concessions[i].license_expiry_date);
          }
        }
      });
    };

    //button next to product page
    $scope.nextToProduct = function(){
      if (!$scope.concession.selected.address) {
        $scope.error = 'Please fill Address !';
        return;
      }
      if (!$scope.concession.selected.city) {
        $scope.error = 'Please fill City !';
        return;
      }
      if (!$scope.concession.selected.country) {
        $scope.error = 'Please fill Country !';
        return;
      }
      $scope.lead = new Lead({
        company_id: $stateParams.supplier_id,
        concession_id: $scope.concession.selected.id,
        address: $scope.concession.selected.address,
        city: $scope.concession.selected.city,
        country: $scope.concession.selected.country,
        latitude: $scope.concession.selected.latitude,
        longitude: $scope.concession.selected.longitude,
        order_status: 2
      });
      $scope.lead.$update({ lead_type: 'buy', id: $stateParams.id }, function(res) {
        $location.path('lead/buy/create/product/'+$stateParams.id+'/'+$stateParams.supplier_id+'/'+$scope.concession.selected.id);
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