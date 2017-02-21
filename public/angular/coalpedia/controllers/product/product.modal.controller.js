'use strict';

angular.module('coalpedia').controller('ProductModalController', ['$scope', '$uibModalInstance', '$timeout', '$interval', 'Product', 'Company', 'Environment', 'product', 'company', 'createNew',
  function($scope, $uibModalInstance, $timeout, $interval, Product, Company, Environment, product, company, createNew) {
    $scope.product = product;
    $scope.company = company;
    if(createNew) $scope.createNew = createNew;

    $scope.productQuality = Environment.productQuality;

    $scope.selected = {};

    $scope.find = function (keyword) {
      Product.query({ q: keyword }, function(res){
        if(res.length > 0) $scope.products = res;
      });
    };

    $scope.create = function() {
      var product = new Product($scope.product);

      if(Environment.productQuality !== 'typical'){
        product.gcv_adb_max = product.gcv_adb_min;
        product.gcv_arb_max = product.gcv_arb_min;
        product.ncv_max = product.ncv_min;
        product.tm_max = product.tm_min;
        product.im_max = product.im_min;
        product.vm_max = product.vm_min;
        product.ash_max = product.ash_min;
        product.fc_max = product.fc_min;
        product.ts_max = product.ts_min;
        product.hgi_max = product.hgi_min;
        product.size_max = product.size_min;
        product.fe2o3_max = product.fe2o3_min;
        product.aft_max = product.aft_min;
        product.na2o_max = product.na2o_min;
      }

      product.company_id = company.id;

      product.$save(function(response) {
        $uibModalInstance.close(response);
      });
    };

    $scope.update = function() {
      $scope.product.company_id = company.id;

      $scope.product.$update({ id: $scope.product.id }, function(response) {
        product = response;
        $uibModalInstance.close(response);
      });
    };

    $scope.attach = function (product) {
      Company.get({ id: company.id, action: 'attach', product_id: $scope.selected.product.id }, function(response){
        $uibModalInstance.close(response.product);
      });
    };

    $scope.close = function () {
      $uibModalInstance.dismiss('cancel');
    };
  }
]);
