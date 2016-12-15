'use strict';

angular.module('lead').controller('LeadProductController', ['$scope', '$stateParams', '$uibModal', 'Product', 'Lead',
  function ($scope, $stateParams, $uibModal, Product, Lead) {
    $scope.$watch('selected.product', function (newValue, oldValue) {
      if($scope.lead){
        if(newValue){
          $scope.lead.product_id = newValue.id;
          $scope.lead.product_name = newValue.product_name;
          $scope.lead.typical_quality = newValue.typical_quality;

          $scope.lead.gcv_adb_min = newValue.gcv_adb_min;
          $scope.lead.gcv_adb_min = newValue.gcv_adb_max;
          $scope.lead.gcv_arb_min = newValue.gcv_arb_min;
          $scope.lead.gcv_arb_min = newValue.gcv_arb_max;
          $scope.lead.ncv_min = newValue.ncv_min;
          $scope.lead.ncv_min = newValue.ncv_max;
          $scope.lead.tm_min = newValue.tm_min;
          $scope.lead.tm_min = newValue.tm_max;
          $scope.lead.im_min = newValue.im_min;
          $scope.lead.im_min = newValue.im_max;
          $scope.lead.vm_min = newValue.vm_min;
          $scope.lead.vm_min = newValue.vm_max;
          $scope.lead.ash_min = newValue.ash_min;
          $scope.lead.ash_min = newValue.ash_max;
          $scope.lead.fc_min = newValue.fc_min;
          $scope.lead.fc_min = newValue.fc_max;
          $scope.lead.ts_min = newValue.ts_min;
          $scope.lead.ts_min = newValue.ts_max;
          $scope.lead.hgi_min = newValue.hgi_min;
          $scope.lead.hgi_min = newValue.hgi_max;
          $scope.lead.size_min = newValue.size_min;
          $scope.lead.size_min = newValue.size_max;
          $scope.lead.fe2o3_min = newValue.fe2o3_min;
          $scope.lead.fe2o3_min = newValue.fe2o3_max;
          $scope.lead.aft_min = newValue.aft_min;
          $scope.lead.aft_min = newValue.aft_max;
        }
        else $scope.lead.product_id = undefined;
      }
    });

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
          company: $scope.lead.company
        }
      });

      modalInstance.result.then(function (res) {
        $scope.selected.product = res;
      });
    };
  }
]);