'use strict';

angular.module('lead').controller('ProductLeadBuyController', ['$scope', '$stateParams', '$location', '$uibModal', 'Product', 'Lead',
  function($scope, $stateParams, $location, $uibModal, Product, Lead) {

    $scope.product = {};
    $scope.order_id = $stateParams.order_id;

    //Init select product
    $scope.findProducts = function() {
      Product.query({ supplier_id: $stateParams.supplier_id  }, function(res){
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

    //back button to concession
    $scope.backToConcession = function(){
      $location.path('lead/buy/create/concession/'+$stateParams.id+'/'+$stateParams.supplier_id);
    };

    //button next to port page and update lead
    $scope.nextToPort = function(){
      if (!($scope.product.selected.gcv_arb_min&&$scope.product.selected.gcv_arb_max)) {
        $scope.error = 'Please fill Min & Max GCV Arb !';
        return;
      }
      if (!($scope.product.selected.gcv_adb_min&&$scope.product.selected.gcv_adb_max)) {
        $scope.error = 'Please fill Min & Max GCV Adb !';
        return;
      }
      if (!($scope.product.selected.ncv_min&&$scope.product.selected.ncv_max)) {
        $scope.error = 'Please fill Min & Max NCV !';
        return;
      }
      if($scope.product.selected.volume) {
        if (($scope.product.selected.gcv_arb_reject&&$scope.product.selected.gcv_arb_bonus)||
          ($scope.product.selected.gcv_adb_reject&&$scope.product.selected.gcv_adb_bonus)||
          ($scope.product.selected.ncv_reject&&$scope.product.selected.ncv_bonus)
          ){
          Lead.query({ lead_type: 'buy', id: $stateParams.id }, function(res){
            $scope.lead = res;
            $scope.lead.seller_id = $stateParams.id;
            $scope.lead.product_name = $scope.product.selected.product_name;
            $scope.lead.typical_quality = $scope.product.selected.typical_quality;
            $scope.lead.product_id = $scope.product.selected.id;
            $scope.lead.gcv_arb_min = $scope.product.selected.gcv_arb_min;
            $scope.lead.gcv_arb_max = $scope.product.selected.gcv_arb_max;
            $scope.lead.gcv_arb_reject = $scope.product.selected.gcv_arb_reject;
            $scope.lead.gcv_arb_bonus = $scope.product.selected.gcv_arb_bonus;
            $scope.lead.gcv_adb_min = $scope.product.selected.gcv_adb_min;
            $scope.lead.gcv_adb_max = $scope.product.selected.gcv_adb_max;
            $scope.lead.gcv_adb_reject = $scope.product.selected.gcv_adb_reject;
            $scope.lead.gcv_adb_bonus = $scope.product.selected.gcv_adb_bonus;
            $scope.lead.ncv_min = $scope.product.selected.ncv_min;
            $scope.lead.ncv_max = $scope.product.selected.ncv_max;
            $scope.lead.ncv_reject = $scope.product.selected.ncv_reject;
            $scope.lead.ncv_bonus = $scope.product.selected.ncv_bonus;
            $scope.lead.ash_min = $scope.product.selected.ash_min;
            $scope.lead.ash_max = $scope.product.selected.ash_max;
            $scope.lead.ash_reject = $scope.product.selected.ash_reject;
            $scope.lead.ash_bonus = $scope.product.selected.ash_bonus;
            $scope.lead.ts_min = $scope.product.selected.ts_min;
            $scope.lead.ts_max = $scope.product.selected.ts_max;
            $scope.lead.ts_reject = $scope.product.selected.ts_reject;
            $scope.lead.ts_bonus = $scope.product.selected.ts_bonus;
            $scope.lead.tm_min = $scope.product.selected.tm_min;
            $scope.lead.tm_max = $scope.product.selected.tm_max;
            $scope.lead.tm_reject = $scope.product.selected.tm_reject;
            $scope.lead.tm_bonus = $scope.product.selected.tm_bonus;
            $scope.lead.im_min = $scope.product.selected.im_min;
            $scope.lead.im_max = $scope.product.selected.im_max;
            $scope.lead.im_reject = $scope.product.selected.im_reject;
            $scope.lead.im_bonus = $scope.product.selected.im_bonus;
            $scope.lead.fc_min = $scope.product.selected.fc_min;
            $scope.lead.fc_max = $scope.product.selected.fc_max;
            $scope.lead.fc_reject = $scope.product.selected.fc_reject;
            $scope.lead.fc_bonus = $scope.product.selected.fc_bonus;
            $scope.lead.vm_min = $scope.product.selected.vm_min;
            $scope.lead.vm_max = $scope.product.selected.vm_max;
            $scope.lead.vm_reject = $scope.product.selected.vm_reject;
            $scope.lead.vm_bonus = $scope.product.selected.vm_bonus;
            $scope.lead.hgi_min = $scope.product.selected.hgi_min;
            $scope.lead.hgi_max = $scope.product.selected.hgi_max;
            $scope.lead.hgi_reject = $scope.product.selected.hgi_reject;
            $scope.lead.hgi_bonus = $scope.product.selected.hgi_bonus;
            $scope.lead.size_min = $scope.product.selected.size_min;
            $scope.lead.size_max = $scope.product.selected.size_max;
            $scope.lead.size_reject = $scope.product.selected.size_reject;
            $scope.lead.size_bonus = $scope.product.selected.size_bonus;
            $scope.lead.fe2o3_min = $scope.product.selected.fe2o3_min;
            $scope.lead.fe2o3_max = $scope.product.selected.fe2o3_max;
            $scope.lead.fe2o3_reject = $scope.product.selected.fe2o3_reject;
            $scope.lead.fe2o3_bonus = $scope.product.selected.fe2o3_bonus;
            $scope.lead.aft_min = $scope.product.selected.aft_min;
            $scope.lead.aft_max = $scope.product.selected.aft_max;
            $scope.lead.aft_reject = $scope.product.selected.aft_reject;
            $scope.lead.aft_bonus = $scope.product.selected.aft_bonus;
            $scope.lead.volume = $scope.product.selected.volume;
            $scope.lead.order_status = 3;
            console.log($scope.lead);
            
            $scope.lead.$update({ lead_type: 'buy', id: $stateParams.id }, function(res) {
              $location.path('lead/buy/create/port/'+$stateParams.id+'/'+$stateParams.supplier_id+'/'+$stateParams.concession_id);
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