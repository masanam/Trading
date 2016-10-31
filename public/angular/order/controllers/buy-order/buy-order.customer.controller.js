'use strict';

angular.module('order').controller('BuyOrderCustomerController', ['$scope', '$stateParams', '$location', '$uibModal', 'Buyer', 'Order', 'NgMap',
  function ($scope, $stateParams, $location, $uibModal, Buyer, Order, NgMap) {

    $scope.buyer = {};
    $scope.order_id = $stateParams.order_id;

    //Init select customer
    $scope.findAllBuyers = function() {
      $scope.buyers = Buyer.query();
    };

    //button next to factory page
    $scope.nextToFactory = function(order_id){
      $scope.order = order_id ;
      //new order
      console.log($scope.order.order_id);
      if ($scope.order.order_id===undefined) {
        $scope.order = new Order({
          buyer_id: $scope.buyer.selected.id
        });
        $scope.order.$save({ type: 'buy' }, function(res) {
          $location.path('buy-order/create/factory/'+$scope.buyer.selected.id+'/'+res.id);
        });
      }
      //order from back
      else if ($scope.order.order_id) {
        $scope.order = new Order({
          buyer_id: $scope.buyer.selected.id,
          order_status: 1
        });
        $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
          $location.path('buy-order/create/factory/'+$scope.buyer.selected.id+'/'+res.id);
        });
      }
    };

    //open modal create customer
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/buy-order/modal.customer.view.html',
        controller: 'ModalBuyOrderController',
        scope: $scope
      });
    };

  }
]);