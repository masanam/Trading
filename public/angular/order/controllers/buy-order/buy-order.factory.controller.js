'use strict';

angular.module('order').controller('BuyOrderFactoryController', ['$scope', '$stateParams', '$location', '$uibModal', 'Factory', 'Order',
  function($scope, $stateParams, $location, $uibModal, Factory, Order) {

    $scope.factory = {};
    $scope.order_id = $stateParams.order_id;

    //Init select factory
    $scope.findMyFactorys = function() {
      $scope.factorys = Factory.query({ action: 'my', id: $stateParams.id }, function(factorys){
        if(factorys.length === 0){
          $scope.openModal();
        }
      });
    };

    //button next to product page
    $scope.nextToProduct = function(){
      $scope.order = new Order({
        buyer_id: $stateParams.id,
        factory_id: $scope.factory.selected.id,
        address: $scope.factory.selected.address,
        city: $scope.factory.selected.city,
        country: $scope.factory.selected.country,
        latitude: $scope.factory.selected.latitude,
        longitude: $scope.factory.selected.longitude,
        order_status: 2
      });
      $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
        $location.path('buy-order/create/product/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$scope.factory.selected.id);
      });
    };
    
    //open modal create factory
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/buy-order/modal.factory.view.html',
        controller: 'FactoryModalBuyOrderController',
        scope: $scope
      });
    };

  }
]);