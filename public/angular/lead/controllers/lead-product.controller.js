'use strict';

angular.module('lead').controller('LeadProductController', ['$scope', '$stateParams', '$uibModal', 'Product', 'Lead',
  function ($scope, $stateParams, $uibModal, Product, Lead) {

    //$scope.lead = Lead.get({ id:$stateParams.id });

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

        /*$scope.lead.product_id = res.id;
        $scope.lead.product_name = res.product_name;
        $scope.lead.typical_quality = res.typical_quality;

        $scope.lead.gcv_adb_min = res.gcv_adb_min;
        $scope.lead.gcv_adb_max = res.gcv_adb_max;
        $scope.lead.gcv_arb_min = res.gcv_arb_min;
        $scope.lead.gcv_arb_max = res.gcv_arb_max;
        $scope.lead.ncv_min = res.ncv_min;
        $scope.lead.ncv_max = res.ncv_max;
        $scope.lead.tm_min = res.tm_min;
        $scope.lead.tm_max = res.tm_max;
        $scope.lead.im_min = res.im_min;
        $scope.lead.im_max = res.im_max;
        $scope.lead.vm_min = res.vm_min;
        $scope.lead.vm_max = res.vm_max;
        $scope.lead.ash_min = res.ash_min;
        $scope.lead.ash_max = res.ash_max;
        $scope.lead.fc_min = res.fc_min;
        $scope.lead.fc_max = res.fc_max;
        $scope.lead.ts_min = res.ts_min;
        $scope.lead.ts_max = res.ts_max;
        $scope.lead.hgi_min = res.hgi_min;
        $scope.lead.hgi_max = res.hgi_max;
        $scope.lead.size_min = res.size_min;
        $scope.lead.size_max = res.size_max;
        $scope.lead.fe2o3_min = res.fe2o3_min;
        $scope.lead.fe2o3_max = res.fe2o3_max;
        $scope.lead.aft_min = res.aft_min;
        $scope.lead.aft_max = res.aft_max;*/
      });
    };

    $scope.select = function (product) {
      if($scope.lead){
        if(product){
          $scope.lead.product_id = product.id;
          $scope.lead.product_name = product.product_name;
          $scope.lead.typical_quality = product.typical_quality;

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
        }
        else $scope.lead.product_id = undefined;
      }
    };
  }
]);
