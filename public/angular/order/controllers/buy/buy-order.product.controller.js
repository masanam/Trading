'use strict';

angular.module('order').controller('BuyOrderProductController', ['$scope', '$stateParams', '$location', '$uibModal', 'Product', 'Order',
  function($scope, $stateParams, $location, $uibModal, Product, Order) {

    $scope.product = {};
    $scope.order_id = $stateParams.order_id;

    //Init select product
    $scope.findMyProducts = function() {
      $scope.products = Product.query({ action: 'my', id: $stateParams.id, type: 'buyer' }, function(res){
        if(res.length === 0){
          $scope.openModal();
        }
        for (var i=0; i<res.length; i++){
          res[i].ash_min = parseFloat(res[i].ash_min);
          res[i].ash_max = parseFloat(res[i].ash_max);
          res[i].ts_min = parseFloat(res[i].ts_min);
          res[i].ts_max = parseFloat(res[i].ts_max);
          res[i].tm_min = parseFloat(res[i].tm_min);
          res[i].tm_max = parseFloat(res[i].tm_max);
          res[i].im_min = parseFloat(res[i].im_min);
          res[i].im_max = parseFloat(res[i].im_max);
          res[i].fc_min = parseFloat(res[i].fc_min);
          res[i].fc_max = parseFloat(res[i].fc_max);
          res[i].vm_min = parseFloat(res[i].vm_min);
          res[i].vm_max = parseFloat(res[i].vm_max);
        }
        $scope.products = res;
      });
    };

    //back button to factory
    $scope.backToFactory = function(){
      $location.path('buy-order/create/factory/'+$stateParams.id+'/'+$stateParams.order_id);
    };

    //button next to port page and update order
    $scope.nextToPort = function(){
      if($scope.product.selected.volume) {
        if (($scope.product.selected.gcv_arb_reject&&$scope.product.selected.gcv_arb_bonus)||
          ($scope.product.selected.gcv_adb_reject&&$scope.product.selected.gcv_adb_bonus)||
          ($scope.product.selected.ncv_reject&&$scope.product.selected.ncv_bonus)
          ){
          Order.get({ type: 'buy', id: $stateParams.order_id }, function(res){
            $scope.order = res;
            $scope.order.buyer_id = $stateParams.id;
            $scope.order.product_name = $scope.product.selected.product_name;
            $scope.order.typical_quality = $scope.product.selected.typical_quality;
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
            $scope.order.fe2o3_min = $scope.product.selected.fe2o3_min;
            $scope.order.fe2o3_max = $scope.product.selected.fe2o3_max;
            $scope.order.fe2o3_reject = $scope.product.selected.fe2o3_reject;
            $scope.order.fe2o3_bonus = $scope.product.selected.fe2o3_bonus;
            $scope.order.aft_min = $scope.product.selected.aft_min;
            $scope.order.aft_max = $scope.product.selected.aft_max;
            $scope.order.aft_reject = $scope.product.selected.aft_reject;
            $scope.order.aft_bonus = $scope.product.selected.aft_bonus;
            $scope.order.volume = $scope.product.selected.volume;
            $scope.order.order_status = 3;
            
            $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
              $location.path('buy-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
            });
          });
        }else{
          $scope.error = 'Please fill Bonus and Reject Contract !';
        }
      }
      else{
        $scope.error = 'Please fill Volume of Coal !';
      }
      
    };
    
    //open modal create factory
    $scope.openModal = function () {
      var modalInstance = $uibModal.open({
        windowClass: 'xl-modal',
        templateUrl: './angular/order/views/buy-order/modal.product.view.html',
        controller: 'ProductModalBuyOrderController',
        scope: $scope
      });
    };

  }
]);