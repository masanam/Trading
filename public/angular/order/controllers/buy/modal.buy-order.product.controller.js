'use strict';

angular.module('order').controller('ProductModalBuyOrderController',
  function($scope, $stateParams, $uibModalInstance, $location, $interval, Product, Order) {

    $scope.init = function () {
      $scope.product = new Product();
      $scope.bonusreject = new Product();
    };

    $scope.create = function(){
      $scope.product.buyer_id = $stateParams.id;
      $scope.product.$save(function (res) {
        $scope.progress = 0;
        $scope.success = true;
        $scope.product = res;
        var stop = $interval(function() {
          if ($scope.progress >= 0 && $scope.progress < 100) {
            $scope.progress++;
          } else {
            $interval.cancel(stop);
            stop = undefined;
            Order.get({ type: 'buy', id: $stateParams.order_id }, function(res){
              $scope.order = res;
              $scope.order.buyer_id = $stateParams.id;
              $scope.order.product_name = $scope.product.product_name;
              $scope.order.typical_quality = $scope.product.typical_quality;
              $scope.order.product_id = $scope.product.id;
              $scope.order.gcv_arb_min = $scope.product.gcv_arb_min;
              $scope.order.gcv_arb_max = $scope.product.gcv_arb_max;
              $scope.order.gcv_arb_reject = $scope.bonusreject.gcv_arb_reject;
              $scope.order.gcv_arb_bonus = $scope.bonusreject.gcv_arb_bonus;
              $scope.order.gcv_adb_min = $scope.product.gcv_adb_min;
              $scope.order.gcv_adb_max = $scope.product.gcv_adb_max;
              $scope.order.gcv_adb_reject = $scope.bonusreject.gcv_adb_reject;
              $scope.order.gcv_adb_bonus = $scope.bonusreject.gcv_adb_bonus;
              $scope.order.ncv_min = $scope.product.ncv_min;
              $scope.order.ncv_max = $scope.product.ncv_max;
              $scope.order.ncv_reject = $scope.bonusreject.ncv_reject;
              $scope.order.ncv_bonus = $scope.bonusreject.ncv_bonus;
              $scope.order.ash_min = $scope.product.ash_min;
              $scope.order.ash_max = $scope.product.ash_max;
              $scope.order.ash_reject = $scope.bonusreject.ash_reject;
              $scope.order.ash_bonus = $scope.bonusreject.ash_bonus;
              $scope.order.ts_min = $scope.product.ts_min;
              $scope.order.ts_max = $scope.product.ts_max;
              $scope.order.ts_reject = $scope.bonusreject.ts_reject;
              $scope.order.ts_bonus = $scope.bonusreject.ts_bonus;
              $scope.order.tm_min = $scope.product.tm_min;
              $scope.order.tm_max = $scope.product.tm_max;
              $scope.order.tm_reject = $scope.bonusreject.tm_reject;
              $scope.order.tm_bonus = $scope.bonusreject.tm_bonus;
              $scope.order.im_min = $scope.product.im_min;
              $scope.order.im_max = $scope.product.im_max;
              $scope.order.im_reject = $scope.bonusreject.im_reject;
              $scope.order.im_bonus = $scope.bonusreject.im_bonus;
              $scope.order.fc_min = $scope.product.fc_min;
              $scope.order.fc_max = $scope.product.fc_max;
              $scope.order.fc_reject = $scope.bonusreject.fc_reject;
              $scope.order.fc_bonus = $scope.bonusreject.fc_bonus;
              $scope.order.vm_min = $scope.product.vm_min;
              $scope.order.vm_max = $scope.product.vm_max;
              $scope.order.vm_reject = $scope.bonusreject.vm_reject;
              $scope.order.vm_bonus = $scope.bonusreject.vm_bonus;
              $scope.order.hgi_min = $scope.product.hgi_min;
              $scope.order.hgi_max = $scope.product.hgi_max;
              $scope.order.hgi_reject = $scope.bonusreject.hgi_reject;
              $scope.order.hgi_bonus = $scope.bonusreject.hgi_bonus;
              $scope.order.size_min = $scope.product.size_min;
              $scope.order.size_max = $scope.product.size_max;
              $scope.order.size_reject = $scope.bonusreject.size_reject;
              $scope.order.size_bonus = $scope.bonusreject.size_bonus;
              $scope.order.fe2o3_min = $scope.product.fe2o3_min;
              $scope.order.fe2o3_max = $scope.product.fe2o3_max;
              $scope.order.fe2o3_reject = $scope.bonusreject.fe2o3_reject;
              $scope.order.fe2o3_bonus = $scope.bonusreject.fe2o3_bonus;
              $scope.order.aft_min = $scope.product.aft_min;
              $scope.order.aft_max = $scope.product.aft_max;
              $scope.order.aft_reject = $scope.bonusreject.aft_reject;
              $scope.order.aft_bonus = $scope.bonusreject.aft_bonus;
              $scope.order.volume = $scope.bonusreject.volume;
              $scope.order.order_status = 3;

              $scope.order.$update({ type: 'buy', id: $stateParams.order_id }, function(res) {
                $location.path('buy-order/create/port/'+$stateParams.id+'/'+$stateParams.order_id+'/'+$stateParams.factory_id);
                $uibModalInstance.close('success');
              });
            });
          }
        }, 75);
      });
      
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
    
  }
);
