'use strict';

angular.module('order').controller('SellOrderProductController', ['$scope', '$stateParams', '$location', '$uibModal', 'Product', 'Order',
  function($scope, $stateParams, $location, $uibModal, Product, Order) {

    $scope.product = {};
    $scope.order_id = $stateParams.order_id;

    //Init select product
    $scope.findMyProducts = function() {
      $scope.products = Product.query({ action: 'my', id: $stateParams.id, type: 'seller' }, function(products){
        if(products.length === 0){
          $scope.openModal();
        }
      });
    };

    //back button to concession
    $scope.backToConcession = function(){
      $location.path('sell-order/create/concession/'+$stateParams.id+'/'+$stateParams.order_id);
    };

    //button next to port page and update order
    $scope.nextToPort = function(){
      if($scope.product.selected.volume) {
        Order.get({ type: 'sell', id: $stateParams.order_id }, function(res){
          $scope.order = res;
          $scope.order.seller_id = $stateParams.id;
          $scope.order.product_name = $scope.product.selected.product_name;
          $scope.order.product_id = $scope.product.selected.id;
          $scope.order.gcv_arb_min = $scope.product.selected.gcv_arb_min;
          $scope.order.gcv_arb_max = $scope.product.selected.gcv_arb_max;
          $scope.order.gcv_arb_reject = $scope.product.selected.gcv_arb_reject;
          $scope.order.gcv_arb_bonus = $scope.product.selected.gcv_arb_bonus;
          $scope.order.gcv_adb_min = $scope.product.selected.gcv_adb_min;
          $scope.order.gcv_adb_max = $scope.product.selected.gcv_adb_max;
          $scope.order.gcv_adb_reject = $scope.product.selected.gcv_adb_reject;
          $scope.order.gcv_adb_bonus = $scope.product.selected.gcv_adb_bonus;
          $scope.order.ncv_min = $scope.product.selected.ncv_min;
          $scope.order.ncv_max = $scope.product.selected.ncv_max;
          $scope.order.ncv_reject = $scope.product.selected.ncv_reject;
          $scope.order.ncv_bonus = $scope.product.selected.ncv_bonus;
          $scope.order.ash_min = $scope.product.selected.ash_min;
          $scope.order.ash_max = $scope.product.selected.ash_max;
          $scope.order.ash_reject = $scope.product.selected.ash_reject;
          $scope.order.ash_bonus = $scope.product.selected.ash_bonus;
          $scope.order.ts_min = $scope.product.selected.ts_min;
          $scope.order.ts_max = $scope.product.selected.ts_max;
          $scope.order.ts_reject = $scope.product.selected.ts_reject;
          $scope.order.ts_bonus = $scope.product.selected.ts_bonus;
          $scope.order.tm_min = $scope.product.selected.tm_min;
          $scope.order.tm_max = $scope.product.selected.tm_max;
          $scope.order.tm_reject = $scope.product.selected.tm_reject;
          $scope.order.tm_bonus = $scope.product.selected.tm_bonus;
          $scope.order.im_min = $scope.product.selected.im_min;
          $scope.order.im_max = $scope.product.selected.im_max;
          $scope.order.im_reject = $scope.product.selected.im_reject;
          $scope.order.im_bonus = $scope.product.selected.im_bonus;
          $scope.order.fc_min = $scope.product.selected.fc_min;
          $scope.order.fc_max = $scope.product.selected.fc_max;
          $scope.order.fc_reject = $scope.product.selected.fc_reject;
          $scope.order.fc_bonus = $scope.product.selected.fc_bonus;
          $scope.order.vm_min = $scope.product.selected.vm_min;
          $scope.order.vm_max = $scope.product.selected.vm_max;
          $scope.order.vm_reject = $scope.product.selected.vm_reject;
          $scope.order.vm_bonus = $scope.product.selected.vm_bonus;
          $scope.order.hgi_min = $scope.product.selected.hgi_min;
          $scope.order.hgi_max = $scope.product.selected.hgi_max;
          $scope.order.hgi_reject = $scope.product.selected.hgi_reject;
          $scope.order.hgi_bonus = $scope.product.selected.hgi_bonus;
          $scope.order.size_min = $scope.product.selected.size_min;
          $scope.order.size_max = $scope.product.selected.size_max;
          $scope.order.size_reject = $scope.product.selected.size_reject;
          $scope.order.size_bonus = $scope.product.selected.size_bonus;
          $scope.order.volume = $scope.product.selected.volume;
          $scope.order.order_status = 3;
          
          $scope.order.$update({ type: 'sell', id: $stateParams.order_id }, function(res) {
            $location.path('sell-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.concession_id);
          });
        });
      }
      else{
        $scope.error = 'Please fill Volume of Coal !';
      }
      
    };
    
    //open modal create concession
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/sell-order/modal.product.view.html',
        controller: 'ProductModalSellOrderController',
        scope: $scope
      });
    };

  }
]);