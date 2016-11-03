'use strict';

angular.module('order').controller('SellOrderConcessionController', ['$scope', '$stateParams', '$location', '$filter', '$uibModal', 'Concession', 'Order',
  function($scope, $stateParams, $location, $filter, $uibModal, Concession, Order) {

    $scope.concession = {};
    $scope.order_id = $stateParams.order_id;

    //Init select concession
    $scope.findMyConcessions = function() {
      $scope.concessions = Concession.query({ action: 'my', id: $stateParams.id }, function(concessions){
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
      $scope.order = new Order({
        seller_id: $stateParams.id,
        concession_id: $scope.concession.selected.id,
        address: $scope.concession.selected.address,
        city: $scope.concession.selected.city,
        country: $scope.concession.selected.country,
        latitude: $scope.concession.selected.latitude,
        longitude: $scope.concession.selected.longitude,
        order_status: 2
      });
      $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
        $scope.order.factory_id = $scope.concession.selected.id;
        $location.path('sell-order/create/product/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$scope.concession.selected.id);
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