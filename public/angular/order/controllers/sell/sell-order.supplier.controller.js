'use strict';

angular.module('order').controller('SellOrderSupplierController', ['$scope', '$stateParams', '$location', '$uibModal', 'Seller', 'Order', 'NgMap',
  function ($scope, $stateParams, $location, $uibModal, Seller, Order, NgMap) {

    $scope.seller = {};
    $scope.order_id = $stateParams.order_id;

    //Init select supplier
    $scope.findAllSellers = function() {
      $scope.sellers = Seller.query();
    };

    //button next to concession page
    $scope.nextToConcession = function(order_id){
      $scope.order = order_id ;
      //new order
      if ($scope.order.order_id===undefined) {
        $scope.order = new Order({
          seller_id: $scope.seller.selected.id
        });
        $scope.order.$save({ type: 'sell' }, function(res) {
          $location.path('sell-order/create/concession/'+$scope.seller.selected.id+'/'+res.id);
        });
      }
      //order from back
      else if ($scope.order.order_id) {
        $scope.order = new Order({
          seller_id: $scope.seller.selected.id,
          order_status: 1
        });
        $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
          $location.path('sell-order/create/concession/'+$scope.seller.selected.id+'/'+res.id);
        });
      }
    };

    //open modal create supplier
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/sell-order/modal.supplier.view.html',
        controller: 'ModalSellOrderController',
        scope: $scope
      });
    };

  }
]);