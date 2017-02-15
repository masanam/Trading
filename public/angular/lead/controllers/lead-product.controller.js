'use strict';

angular.module('lead').controller('LeadProductController', ['$scope', '$stateParams', '$uibModal', 'Product', 'Lead', 'Environment',
  function ($scope, $stateParams, $uibModal, Product, Lead, Environment) {

    //Init select products
    $scope.find = function(keyword) {
      Product.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.products = res;
      });
    };

    $scope.add = function () {
      var modalInstance = $uibModal.open({
        animation: true,
        ariaLabelledBy: 'modal-title',
        ariaDescribedBy: 'modal-body',
        templateUrl: './angular/coalpedia/views/product/_create.modal.view.html',
        controller: 'ProductModalController',
        windowClass: 'xl-modal',
        resolve: {
          product: new Product(),
          company: $scope.lead.company,
          createNew: true
        }
      });

      modalInstance.result.then(function (res) {
        $scope.products.push(res);
        $scope.selected.product = res;
        $scope.select(res);
      });
    };

    $scope.select = function (product) {
      if($scope.lead){
        if(product){
          $scope.lead.product_id = product.id;
          $scope.lead.product_name = product.product_name;
          $scope.lead.typical_quality = product.typical_quality;
          if(Environment.productQuality !== 'typical'){
            $scope.lead.gcv_adb_min = product.gcv_adb_min;
            $scope.lead.gcv_adb_max = product.gcv_adb_max;
            $scope.lead.gcv_arb_min = product.gcv_arb_min;
            $scope.lead.gcv_arb_max = product.gcv_arb_max;
            $scope.lead.ncv_min = product.ncv_min;
            $scope.lead.ncv_max = product.ncv_max;
            $scope.lead.tm_min = product.tm_min;
            $scope.lead.tm_max = product.tm_max;
            $scope.lead.im_min = product.im_min;
            $scope.lead.im_max = product.im_max;
            $scope.lead.vm_min = product.vm_min;
            $scope.lead.vm_max = product.vm_max;
            $scope.lead.ash_min = product.ash_min;
            $scope.lead.ash_max = product.ash_max;
            $scope.lead.fc_min = product.fc_min;
            $scope.lead.fc_max = product.fc_max;
            $scope.lead.ts_min = product.ts_min;
            $scope.lead.ts_max = product.ts_max;
            $scope.lead.hgi_min = product.hgi_min;
            $scope.lead.hgi_max = product.hgi_max;
            $scope.lead.size_min = product.size_min;
            $scope.lead.size_max = product.size_max;
            $scope.lead.fe2o3_min = product.fe2o3_min;
            $scope.lead.fe2o3_max = product.fe2o3_max;
            $scope.lead.aft_min = product.aft_min;
            $scope.lead.aft_max = product.aft_max;
            $scope.lead.na2o_min = product.na2o_min;
            $scope.lead.na2o_max = product.na2o_max;
          }else{
            $scope.lead.gcv_adb_min = product.gcv_adb_min;
            $scope.lead.gcv_adb_max = $scope.lead.gcv_adb_min;
            $scope.lead.gcv_arb_min = product.gcv_arb_min;
            $scope.lead.gcv_arb_max = $scope.lead.gcv_arb_min;
            $scope.lead.ncv_min = product.ncv_min;
            $scope.lead.ncv_max = $scope.lead.ncv_min;
            $scope.lead.tm_min = product.tm_min;
            $scope.lead.tm_max = $scope.lead.tm_min;
            $scope.lead.im_min = product.im_min;
            $scope.lead.im_max = $scope.lead.im_min;
            $scope.lead.vm_min = product.vm_min;
            $scope.lead.vm_max = $scope.lead.vm_min;
            $scope.lead.ash_min = product.ash_min;
            $scope.lead.ash_max = $scope.lead.ash_min;
            $scope.lead.fc_min = product.fc_min;
            $scope.lead.fc_max = $scope.lead.fc_min;
            $scope.lead.ts_min = product.ts_min;
            $scope.lead.ts_max = $scope.lead.ts_min;
            $scope.lead.hgi_min = product.hgi_min;
            $scope.lead.hgi_max = $scope.lead.hgi_min;
            $scope.lead.size_min = product.size_min;
            $scope.lead.size_max = $scope.lead.size_min;
            $scope.lead.fe2o3_min = product.fe2o3_min;
            $scope.lead.fe2o3_max = $scope.lead.fe2o3_min;
            $scope.lead.aft_min = product.aft_min;
            $scope.lead.aft_max = $scope.lead.aft_min;
            $scope.lead.na2o_min = product.na2o_min;
            $scope.lead.na2o_max = $scope.lead.na2o_min;
          }
        }
        else $scope.lead.product_id = undefined;
      } 
      console.log($scope.lead);
    };
  }
]);
